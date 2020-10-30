/*
 * Copyright (c) 2020 Anatolii S.
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

jQuery(function ($) {

    $('#buyNowButton').click(function (e) {
        e.preventDefault();

        const button = $(this);
        const name = $('input[name ="_customer_name"]');
        const lname = $('input[name ="_customer_surname"]');
        const email = $('input[name ="_customer_email"]');
        let nameVal = name.val();
        let emailVal = email.val();
        let productId = $(this).data("id");
        let productQuantity = $('input[name ="quantity"]').val();
        let lNameVal = lname.val();

        if (validateName(nameVal) && validateEmail(emailVal)) {
            let productInfo = {
                action: 'doFastOrder',
                nonce_code: buyNowAjax.nonce,
                product_id: productId,
                qty: productQuantity,
                customer_name: nameVal,
                last_name: lNameVal,
                customer_email: emailVal
            }
            $.ajax({
                type: 'POST',
                url: buyNowAjax.ajax_url,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                data: productInfo,
                cache: false,
                beforeSend: function () {
                    button.addClass('loading').attr("disabled", true);
                    //console.log(productInfo);
                },
                success: function (data, textStatus) {
                    $('#order-response').html(textStatus).css({'background': 'green'}).show();
                    button.removeClass('loading').attr("disabled", false);
                    setTimeout(
                        function () {
                            $('#order-response').hide();
                        },
                        3000
                    );
                    //console.log(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#order-response').html(textStatus).css({'background': 'red'}).show();
                    button.removeClass('loading').attr("disabled", false);
                    setTimeout(
                        function () {
                            $('#order-response').hide();
                        },
                        3000
                    );
                    //console.log(JSON.stringify(jqXHR) + " :: " + textStatus + " :: " + errorThrown);
                }
            })
        }
        console.log(validateName(nameVal));
        if (!validateName(nameVal)) {
            name.css({'border': '3px solid red'});
        }
        if (!validateName(lNameVal)) {
            lname.css({'border': '3px solid red'});
        }
        if (!validateEmail(emailVal)) {
            email.css({'border': '3px solid red'});
        }

        name.focus(
            function () {
                $(this).css({'border-color': 'transparent'});
            });
        lname.focus(
            function () {
                $(this).css({'border-color': 'transparent'});
            });
        email.focus(
            function () {
                $(this).css({'border-color': 'transparent'});
            });

        function validateEmail(customerEmail) {
            let regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(customerEmail);
        }

        function validateName(customerName) {
            let regex = /^[a-zA-Zа-яА-Я ]{2,35}$/;
            return regex.test(customerName);
        }

    });
});