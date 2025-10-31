<div id="site">
    <div id="content">



        <form id="checkout-order-form" action="/submit">
            <h2><i class="bi bi-truck"></i>Your Details</h2>
            <div id="checkout-container">
                <fieldset id="fieldset-billing">
                    <div><br></div>
                    <legend>Billing</legend>
                    <div>
                        <label for="nname">Name</label>
                        <input type="text" onchange="updateFormSessionValue('nname','billing')" id="nname" name="nname" data-type="string" value="<?php echo htmlspecialchars($billing['nname'] ?? '') ?>">
                        <span id="billing-nname-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="text" onchange="updateFormSessionValue('email','billing')" 
                        name="email" id="email" data-type="expression" 
                        value="<?php echo htmlspecialchars($billing['email'] ?? '') ?>">
                        <span id="billing-email-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="city">City</label>
                        <input type="text" onchange="updateFormSessionValue('city','billing')" name="city" id="city" data-type="string" value="<?php echo htmlspecialchars($billing['city'] ?? '') ?>">
                        <span id="billing-city-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="address">Address</label>
                        <input type="text" onchange="updateFormSessionValue('address','billing')" name="address" id="address" data-type="string" value="<?php echo htmlspecialchars($billing['address'] ?? '') ?>">
                        <span id="billing-address-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="zip">Post Code</label>
                        <input type="text" onchange="updateFormSessionValue('zip','billing')" name="zip" id="zip" data-type="string" value="<?php echo htmlspecialchars($billing['zip'] ?? '') ?>">
                        <span id="billing-zip-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="country">Country</label>
                        <select onchange="updateFormSessionValue('country','billing')" name="country" id="country" data-type="string">
                        </select>
                        <span id="billing-country-error" class="error" style="color:red;"></span>
                    </div>
                </fieldset>

                <fieldset id="fieldset-shipping">
                    <div id="shipping-same" style="color: black;">Same as Billing <input onclick="repeatAddress()" 
                    type="checkbox" id="same-as-billing" title="same-as-billing" value="" /></div>

                    <legend>Shipping</legend>
                    <div>
                        <label for="sname">Name</label>
                        <input type="text" onchange="updateFormSessionValue('sname','shipping')" name="sname" id="sname" value="<?php echo html_entity_decode(htmlspecialchars($shipping['sname'] ?? '')) ?>" />
                        <span id="shipping-sname-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="semail">Email</label>
                        <input type="text" onchange="updateFormSessionValue('semail','shipping')" name="semail" id="semail" value="<?php echo htmlspecialchars($shipping['semail'] ?? '') ?>" />
                        <span id="shipping-semail-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="scity">City</label>
                        <input type="text" onchange="updateFormSessionValue('scity','shipping')" name="scity" id="scity" value="<?php echo htmlspecialchars($shipping['scity'] ?? '') ?>" />
                        <span id="shipping-scity-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="saddress">Address</label>
                        <input type="text" onchange="updateFormSessionValue('saddress','shipping')" name="saddress" id="saddress" value="<?php echo htmlspecialchars($shipping['saddress'] ?? '') ?>" />
                        <span id="shipping-saddress-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="szip">Post Code</label>
                        <input type="text" onchange="updateFormSessionValue('szip','shipping')" name="szip" id="szip" value="<?php echo htmlspecialchars($shipping['szip'] ?? '') ?>" />
                        <span id="shipping-szip-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="scountry">Country</label>
                        <select onchange="updateFormSessionValue('scountry','shipping')" name="scountry" id="scountry" data-type="string">
                        </select>
                        <span id="shipping-scountry-error" class="error" style="color:red;"></span>
                    </div>
                </fieldset>
                </div>

                <fieldset id="payment">
                    <legend>Payment</legend>
                    <div>
                        <label for="cname">Name on Card</label>
                        <input type="text" id="cname" name="cname" placeholder="Yeti MacBoat" value="<?php echo htmlspecialchars($payment['cname'] ?? '') ?>">
                        <span id="payment-cname-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="ccnum">Credit card number</label>
                        <input type="text" id="ccnum" name="ccnum" placeholder="1111-2222-3333-4444" value="<?php echo htmlspecialchars($payment['ccnum'] ?? '') ?>">
                        <span id="payment-ccnum-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="expmonth">Exp Month</label>
                        <select name="expmonth" id="expmonth" data-type="string">
                        </select>
                        <span id="payment-expmonth-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="expyear">Exp Year</label>
                        <select name="expyear" id="expyear" data-type="string">
                            <option value="<?php echo htmlspecialchars($payment['expyear'] ?? '') ?>" selected><?php echo htmlspecialchars($payment['expyear'] ?? '') ?></option>
                        </select>
                        <span id="payment-expyear-error" class="error" style="color:red;"></span>
                    </div>
                    <div>
                        <label for="cvv">CVV</label>
                        <input type="number" id="cvv" name="cvv" pattern="\d{3}" value="<?php echo htmlspecialchars($payment['cvv'] ?? '') ?>">
                        <span id="payment-cvv-error" class="error" style="color:red;"></span>
                    </div>
                </fieldset>

                <p>
                    <button type="button" onClick="sendCheckoutForms()" class="checkout-btn">Pay Now</button>
                    <button type="button" onClick="clearCheckoutForms()" class="clear-btn">Clear Form</button>
                </p>
            </form>
        </div>
    </div>
</div>
