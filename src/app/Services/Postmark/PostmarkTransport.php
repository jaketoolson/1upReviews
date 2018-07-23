<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services\Postmark;

use Swift_MimePart;
use Swift_Attachment;
use Swift_Mime_SimpleMessage;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use Illuminate\Mail\Transport\Transport;

class PostmarkTransport extends Transport
{
    /**
     * Guzzle client instance.
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * The Postmark API key.
     *
     * @var string
     */
    protected $key;

    /**
     * The Postmark API end-point.
     *
     * @var string
     */
    protected $url = 'https://api.postmarkapp.com/email';

    /**
     * Create a new Postmark transport instance.
     *
     * @param ClientInterface $client
     * @param string $key
     *
     * @return void
     */
    public function __construct(ClientInterface $client, $key)
    {
        $this->key = $key;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $response = $this->client->post($this->url, $this->payload($message));

        $message->getHeaders()->addTextHeader(
            'X-PM-Message-Id',
            $this->getMessageId($response)
        );

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }

    /**
     * Get all attachments for the given message.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return array
     */
    protected function getAttachments(Swift_Mime_SimpleMessage $message): array
    {
        return collect($message->getChildren())
            ->filter(function ($child) {
                return $child instanceof Swift_Attachment;
            })
            ->map(function ($child) {
                return [
                    'Name' => $child->getHeaders()->get('content-type')->getParameter('name'),
                    'Content' => base64_encode($child->getBody()),
                    'ContentType' => $child->getContentType(),
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Format the display name.
     *
     * @param  string $value
     * @return string
     */
    protected function getDisplayname(string $value): string
    {
        if (strpos($value, ',') !== false) {
            return '"' . $value . '"';
        }

        return $value;
    }

    /**
     * Format the contacts for the API request.
     *
     * @param string|array $contacts
     *
     * @return string
     */
    protected function getContacts($contacts): string
    {
        return collect($contacts)
            ->map(function ($display, $address) {
                return $display ? $this->getDisplayname($display) . " <{$address}>" : $address;
            })
            ->values()
            ->implode(',');
    }

    /**
     * Get the message ID from the response.
     *
     * @param Response $response
     *
     * @return string
     */
    protected function getMessageId(Response $response): string
    {
        return object_get(
            json_decode($response->getBody()->getContents()),
            'MessageID'
        );
    }

    /**
     * Get the body for the given message.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return string
     */
    protected function getBody(Swift_Mime_SimpleMessage $message): string
    {
        return $message->getBody() ?: '';
    }

    /**
     * Get the text and html fields for the given message.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return array
     */
    protected function getHtmlAndTextBody(Swift_Mime_SimpleMessage $message): array
    {
        $data = [];

        switch ($message->getContentType()) {
            case 'text/html':
            case 'multipart/mixed':
            case 'multipart/related':
            case 'multipart/alternative':
                $data['HtmlBody'] = $this->getBody($message);
                break;
            default:
                $data['TextBody'] = $this->getBody($message);
                break;
        }

        if ($text = $this->getMimePart($message, 'text/plain')) {
            $data['TextBody'] = $text->getBody();
        }

        if ($html = $this->getMimePart($message, 'text/html')) {
            $data['HtmlBody'] = $html->getBody();
        }

        return $data;
    }

    /**
     * Get a mime part from the given message.
     *
     * @param Swift_Mime_SimpleMessage $message
     * @param string $mimeType
     *
     * @return Swift_MimePart
     */
    protected function getMimePart(Swift_Mime_SimpleMessage $message, string $mimeType): Swift_MimePart
    {
        return collect($message->getChildren())
            ->filter(function ($child) {
                return $child instanceof Swift_MimePart;
            })
            ->filter(function ($child) use ($mimeType) {
                return strpos($child->getContentType(), $mimeType) === 0;
            })
            ->first();
    }

    /**
     * Get the subject for the given message.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return string
     */
    protected function getSubject(Swift_Mime_SimpleMessage $message): string
    {
        return $message->getSubject() ?: '';
    }

    /**
     * Get the tag for the given message.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return string
     */
    protected function getTag(Swift_Mime_SimpleMessage $message): string
    {
        return optional(
            collect($message->getHeaders()->getAll('tag'))
                ->last()
        )
            ->getFieldBody() ?: '';
    }

    /**
     * Get the HTTP payload for sending the Postmark message.
     *
     * @param Swift_Mime_SimpleMessage $message
     *
     * @return array
     */
    protected function payload(Swift_Mime_SimpleMessage $message): array
    {
        return collect([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Postmark-Server-Token' => $this->key,
            ]
        ])
            ->merge([
                'json' => collect([
                    'Cc' => $this->getContacts($message->getCc()),
                    'Bcc' => $this->getContacts($message->getBcc()),
                    'Tag' => $this->getTag($message),
                    'Subject' => $this->getSubject($message),
                    'ReplyTo' => $this->getContacts($message->getReplyTo()),
                    'Attachments' => $this->getAttachments($message),
                    "Metadata" => [],
                ])
                    ->reject(function ($item) {
                        return empty($item);
                    })
                    ->put('From', $this->getContacts($message->getFrom()))
                    ->put('To', $this->getContacts($message->getTo()))
                    ->merge($this->getHtmlAndTextBody($message))
            ])
            ->toArray();
    }
}
