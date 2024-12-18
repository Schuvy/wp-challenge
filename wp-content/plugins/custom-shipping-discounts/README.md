README.md

Custom Shipping Discounts Plugin

Description:
This plugin modifies WooCommerce shipping rates based on the cart total and user roles.

Features:
•	If the cart total is above $100, apply a 10% discount on shipping.
•	If the cart total is above $150, apply a 5% discount on shipping.
•	If the cart total is above $200, apply a 2.5% discount on shipping.
•	If the user has the “VIP_Customer” role, apply free shipping (set shipping to zero).

Prerequisites:
•	A WordPress installation.
•	WooCommerce installed and activated.
•	This plugin file located in wp-content/plugins/custom-shipping-discounts/.

Installation Steps:
1.	Ensure WooCommerce is active.
2.	Place the custom-shipping-discounts directory into wp-content/plugins/.
3.	Activate the Custom Shipping Discounts plugin from the WordPress admin panel.

Testing the Shipping Discount Rules:
1.	Without any special role (e.g. a regular customer):
   •	Add products to the cart.
   •	Increase cart total to just over $100 and check the shipping rate. It should be reduced by 10%.
   •	Increase cart total to just over $150 and check the shipping rate. It should now be reduced by 5%.
   •	Increase cart total to just over $200 and check the shipping rate. It should now be reduced by 2.5%.

Note: The rules are written so that the highest applicable threshold takes precedence. For instance, if your total is $160, the 5% discount applies, not the 10%.

2. With VIP_Customer Role:
   •	Assign the “VIP_Customer” role to a test user.
   •	Log in as this user and add items to your cart.
   •	Check the shipping cost. It should be $0.00 regardless of the cart total.

Extending the Plugin:
•	Several filters has been added to the plugin logic to allow for easy customization.
•	If you need to apply discounts based on new criteria (like product categories, shipping zones, etc.), you can add more methods or logic to the Shipping_Discount_Calculator class or create new calculation classes and use them in Shipping_Discount_Handler.

Support & Contact:
•	For further customization or troubleshooting, please contact at naexshaman@gmail.com