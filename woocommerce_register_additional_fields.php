<?php 

// Add new fields in woocommerce registration form 
 function wooc_extra_register_fields() {?>

      

     <p class="form-row form-row-first">

         <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>

         <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" placeholder="Enter First Name" />

     </p>

     <p class="form-row form-row-last">

         <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>

         <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" placeholder="Enter Last Name" />

     </p>

     <p class="form-row form-row-first">

         <label for="reg_billing_phone"><?php _e( 'Phone Number', 'woocommerce' ); ?><span class="required">*</span></label>

         <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" placeholder="Enter Phone Number" />

     </p>

     <p class="form-row form-row-last">

         <label for="reg_billing_company"><?php _e( 'Company Name', 'woocommerce' ); ?><span class="required">*</span></label>

         <input type="text" class="input-text" name="billing_company" id="reg_billing_company" value="<?php esc_attr_e( $_POST['billing_company'] ); ?>" placeholder="Enter Company Name" />

     </p>
  				
       <?php

 }

 add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

function wooc_extra_register_fields_end() {?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="confirm_password"><?php esc_html_e( 'Confirm Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="user_password_again" id="confirm_password" autocomplete="confirm-password" />
                </p>
       <?php

 }

 add_action( 'woocommerce_register_form', 'wooc_extra_register_fields_end' );


// Validate First Name and Last name fields value for Registration form 

function custom_woocommerce_process_registration_errors( $validation_errors, $username, $password, $email ){

    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
       $validation_errors->add( 'billing_first_name_error', __( 'First name is required!', 'woocommerce' ) );
    }

    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
       $validation_errors->add( 'billing_last_name_error', __( 'Last name is required!.', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
       $validation_errors->add( 'billing_phone_error', __( 'Phone Number is required!.', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_company'] ) && empty( $_POST['billing_company'] ) ) {
       $validation_errors->add( 'billing_company_error', __( 'Company Name is required!.', 'woocommerce' ) );
    }
    if ( !isset( $_POST['email'] ) || $_POST['email'] == '' ) {
    $validation_errors->add( 'email', __( 'Please enter email address.', 'woocommerce' ) );
    }

    if ( !isset( $_POST['password'] ) || $_POST['password'] == '' ) {
    $validation_errors->add( 'password', __( 'Please enter password.', 'woocommerce' ) );
    }
    if ( $_POST['user_password_again']  != $_POST['password']  ) {
    //$_POST['password'] Default password filed
    $validation_errors->add( 'password_error', __( 'Password not match!.', 'woocommerce' ) );
    }
    
         return $validation_errors;
}

add_filter( 'woocommerce_process_registration_errors', 'custom_woocommerce_process_registration_errors', 10, 4 );

// Save value into database for Registration form 
function wooc_save_extra_register_fields( $customer_id ) {

      if ( isset( $_POST['billing_first_name'] ) ) {

             //First name field which is by default

             update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

             // First name field which is used in WooCommerce

             update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

      }

      if ( isset( $_POST['billing_last_name'] ) ) {

             // Last name field which is by default

             update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

             // Last name field which is used in WooCommerce

             update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

      }

       if ( isset( $_POST['billing_phone'] ) ) {

            // Phone input filed which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );

          }
	       if ( isset( $_POST['billing_company'] ) ) {

            // Phone input filed which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );

          }

}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );