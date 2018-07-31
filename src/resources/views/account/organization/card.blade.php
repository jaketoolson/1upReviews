@extends('layouts.account_withsubmenu')

@section('sub-content')

    <?php
    $opaques = [
        'active' => 1,
        'inactive' => .6,
        'muted' => .2
    ];
    ?>
    <form action="/account/organization/card" method="POST">
        {!! csrf_field() !!}
        <div class="form-group mb-3">
            <label for="name" class="font-weight-medium">Card number</label>
            <input
                    tabindex="1"
                    type="text"
                    name="number"
                    class="form-control"
                    id="form_card_no"
                    data-card-type="{{ null }}"
                    max="9999999999999999"
                    min="0000000000000001"
                    placeholder="{{ null }}">
                @foreach(array_keys(OneUpReviews\Helpers\CreditCardHelper::getAllowedTypes()) as $ccType)
                    <?php $opacity = $opaques['inactive']; ?>
                    <span class="cc_type_wrapper">
                        <img
                                class="cc_type"
                                id="cc_{{$ccType}}"
                                src="{{ OneUpReviews\Helpers\CreditCardHelper::getImagePathByName($ccType) }}"
                                style="margin-right: 1px; margin-top: 5px; margin-bottom: 15px; height: 34px; opacity: {{ $opacity }};">
                                <span class="cc_name sr-only">{{ $ccType }}</span>
                    </span>
                @endforeach

        </div>
        <div class="form-group mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="month" class="font-weight-medium">Expiration month</label>
                    <select tabindex="2" class="form-control" name="expiration_month">
                        @foreach(range(1, 12) as $month)
                            <option
                                    value="{{ $month }}">
                                {{ $month }} - {{ date('F', strtotime("2012-$month-01")) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="month" class="font-weight-medium">Expiration year</label>
                    <select tabindex="3" class="form-control" name="expiration_year">
                        @foreach(range(date("Y"), 2030) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="month" class="font-weight-medium">CVC</label>
                    <input tabindex="4" type="text" name="cvc" class="form-control" minlength="3" maxlength="3">
                </div>
            </div>
        </div>
        <p class="">We do <u>not</u> store your full credit card number or CVC code after we submit it to our credit card processor, Stripe. Stripe does store and protects this information. They are a major credit card processor who specializes in handling this information. You can find out more about Stripe and their PCI compliance at <a href="https://stripe.com/docs/security/stripe" class="_500 text-primary">their website</a>.</p>
        <div class="form-group mt-4">
            <button class="btn btn-success waves-effect waves-light mb-2" type="submit">Save card</button>
        </div>
    </form>

    @push('footer-scripts')
        <script>
            /*
             jQuery Credit Card Validator 1.0
             Copyright 2012-2015 Pawel Decowski
             Permission is hereby granted, free of charge, to any person obtaining a copy
             of this software and associated documentation files (the "Software"), to deal
             in the Software without restriction, including without limitation the rights
             to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
             copies of the Software, and to permit persons to whom the Software
             is furnished to do so, subject to the following conditions:
             The above copyright notice and this permission notice shall be included
             in all copies or substantial portions of the Software.
             THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
             OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
             FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
             THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
             LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
             OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
             IN THE SOFTWARE.
             */
            (function () {
                var $,
                    __indexOf = [].indexOf || function (item) {
                        for (var i = 0, l = this.length; i < l; i++) {
                            if (i in this && this[i] === item) return i;
                        }
                        return -1;
                    };
                $ = jQuery;
                $.fn.validateCreditCard = function (callback, options) {
                    var bind, card, card_type, card_types, get_card_type, is_valid_length, is_valid_luhn, normalize, validate, validate_number, _i, _len, _ref;
                    card_types = [
                        {
                            name: 'american_express',
                            pattern: /^3[47]/,
                            valid_length: [15]
                        }, {
                            name: 'diners_club',
                            pattern: /^(30[0-5]|38[0-5])/,
                            valid_length: [14]
                        }, {
                            name: 'diners_club_international',
                            pattern: /^36/,
                            valid_length: [14]
                        }, {
                            name: 'jcb',
                            pattern: /^35(2[89]|[3-8][0-9])/,
                            valid_length: [16]
                        }, {
                            name: 'laser',
                            pattern: /^(6304|670[69]|6771)/,
                            valid_length: [16, 17, 18, 19]
                        }, {
                            name: 'visa_electron',
                            pattern: /^(4026|417500|4508|4844|491(3|7))/,
                            valid_length: [16]
                        }, {
                            name: 'visa',
                            pattern: /^4/,
                            valid_length: [16]
                        }, {
                            name: 'mastercard',
                            pattern: /^5[1-5]/,
                            valid_length: [16]
                        }, {
                            name: 'maestro',
                            pattern: /^(5018|5020|5038|6304|6759|676[1-3])/,
                            valid_length: [12, 13, 14, 15, 16, 17, 18, 19]
                        }, {
                            name: 'discover',
                            pattern: /^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,
                            valid_length: [16]
                        }
                    ];
                    bind = false;
                    if (callback) {
                        if (typeof callback === 'object') {
                            options = callback;
                            bind = false;
                            callback = null;
                        } else if (typeof callback === 'function') {
                            bind = true;
                        }
                    }
                    if (options == null) {
                        options = {};
                    }
                    if (options.accept == null) {
                        options.accept = (function () {
                            var _i, _len, _results;
                            _results = [];
                            for (_i = 0, _len = card_types.length; _i < _len; _i++) {
                                card = card_types[_i];
                                _results.push(card.name);
                            }
                            return _results;
                        })();
                    }
                    _ref = options.accept;
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        card_type = _ref[_i];
                        if (__indexOf.call((function () {
                            var _j, _len1, _results;
                            _results = [];
                            for (_j = 0, _len1 = card_types.length; _j < _len1; _j++) {
                                card = card_types[_j];
                                _results.push(card.name);
                            }
                            return _results;
                        })(), card_type) < 0) {
                            throw "Credit card type '" + card_type + "' is not supported";
                        }
                    }
                    get_card_type = function (number) {
                        var _j, _len1, _ref1;
                        _ref1 = (function () {
                            var _k, _len1, _ref1, _results;
                            _results = [];
                            for (_k = 0, _len1 = card_types.length; _k < _len1; _k++) {
                                card = card_types[_k];
                                if (_ref1 = card.name, __indexOf.call(options.accept, _ref1) >= 0) {
                                    _results.push(card);
                                }
                            }
                            return _results;
                        })();
                        for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
                            card_type = _ref1[_j];
                            if (number.match(card_type.pattern)) {
                                return card_type;
                            }
                        }
                        return null;
                    };
                    is_valid_luhn = function (number) {
                        var digit, n, sum, _j, _len1, _ref1;
                        sum = 0;
                        _ref1 = number.split('').reverse();
                        for (n = _j = 0, _len1 = _ref1.length; _j < _len1; n = ++_j) {
                            digit = _ref1[n];
                            digit = +digit;
                            if (n % 2) {
                                digit *= 2;
                                if (digit < 10) {
                                    sum += digit;
                                } else {
                                    sum += digit - 9;
                                }
                            } else {
                                sum += digit;
                            }
                        }
                        return sum % 10 === 0;
                    };
                    is_valid_length = function (number, card_type) {
                        var _ref1;
                        return _ref1 = number.length, __indexOf.call(card_type.valid_length, _ref1) >= 0;
                    };
                    validate_number = (function (_this) {
                        return function (number) {
                            var length_valid, luhn_valid;
                            card_type = get_card_type(number);
                            luhn_valid = false;
                            length_valid = false;
                            if (card_type != null) {
                                luhn_valid = is_valid_luhn(number);
                                length_valid = is_valid_length(number, card_type);
                            }
                            return {
                                card_type: card_type,
                                valid: luhn_valid && length_valid,
                                luhn_valid: luhn_valid,
                                length_valid: length_valid
                            };
                        };
                    })(this);
                    validate = (function (_this) {
                        return function () {
                            var number;
                            number = normalize($(_this).val());
                            return validate_number(number);
                        };
                    })(this);
                    normalize = function (number) {
                        return number.replace(/[ -]/g, '');
                    };
                    if (!bind) {
                        return validate();
                    }
                    this.on('input.jccv', (function (_this) {
                        return function () {
                            $(_this).off('keyup.jccv');
                            return callback.call(_this, validate());
                        };
                    })(this));
                    this.on('keyup.jccv', (function (_this) {
                        return function () {
                            return callback.call(_this, validate());
                        };
                    })(this));
                    callback.call(this, validate());
                    return this;
                };
            }).call(this);
            $(function () {
                var ccNumberEl = $('#form_card_no');
                var ccTypes = $('.cc_type');
                var cardTypeFound = false;
                ccNumberEl.on('focus', function () {
                    ccNumberEl.validateCreditCard(function (result) {
                        if (result.card_type) {
                            var cardImg = $('#cc_' + result.card_type.name);
                            console.log(result.card_type.name);
                            if (cardImg && cardImg.length) {
                                cardImg.css({opacity: {{ $opaques['active'] }}});
                                cardTypeFound = true;
                                return;
                            }
                        }
                        cardTypeFound = false;
                        ccTypes.css({opacity:{{ $opaques['muted'] }}});
                    });
                });
                ccNumberEl.on('blur', function () {
                    if (!ccNumberEl.val() || !cardTypeFound) {
                        ccTypes.css({opacity:{{ $opaques['inactive'] }} });
                    }
                });
            });
        </script>
    @endpush

@endsection