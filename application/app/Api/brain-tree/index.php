<?php require_once('includes/global.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="http://localhost/brain-tree/">
</head>
<body>
	<form method="post" action="checkout.php">
		<section>
            <div class="bt-drop-in-wrapper">
                <div id="bt-dropin"></div>
            </div>

            <label for="amount">
                <span class="input-label">Amount</span>
                <div class="input-wrapper amount-wrapper">
                    <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                </div>
            </label>
        </section>

        <button class="button" type="submit" name="test"><span>Test Transaction</span></button>
	</form>
	<script src="https://js.braintreegateway.com/js/braintree-2.27.0.min.js"></script>
    <script>
        var client_token = "<?php echo(Braintree_ClientToken::generate()); ?>";
        braintree.setup(client_token, "dropin", {
            container: "bt-dropin"
        });
    </script>
</body>
</html>