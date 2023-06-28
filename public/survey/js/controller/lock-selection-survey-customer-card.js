"use strict";

/* * JavaScript for the file lock-selection-survey.html - customer card
 *  section.
 *  @author Sanket Rajgarhia
 *  @date   31/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* GLOBAL VARIABLES                                                          */
/*****************************************************************************/

// Global variables - associated with the - Customer Name input control
let customerNameInputPlaceholder = "";
let customerNameDiv = document.getElementById("customer-name-div");
let customerNameInput = document.getElementById("input-customer-name");
let customerNameInvalidFeedback = customerNameDiv
    .getElementsByClassName("invalid-feedback")[0];
let customerNamePrependDiv = customerNameDiv
    .getElementsByClassName("input-group-prepend")[0];
let customerNameInputGroupTextDiv = customerNameDiv
    .getElementsByClassName("input-group-text")[0];

// Global variables - associated with the - Customer Mobile input control
let customerMobileInputPlaceholder = "";
let customerMobileDiv = document.getElementById("customer-mobile-div");
let customerMobileInput = document.getElementById("input-customer-mobile");
let customerMobileInvalidFeedback = customerMobileDiv
    .getElementsByClassName("invalid-feedback")[0];
let customerMobilePrependDiv = customerMobileDiv
    .getElementsByClassName("input-group-prepend")[0];
let customerMobileInputGroupTextDiv = customerMobileDiv
    .getElementsByClassName("input-group-text")[0];

// Global variables - associated with the - Customer Address1 input control
let customerAddress1InputPlaceholder = "";
let customerAddress1Div = document.getElementById("customer-address1-div");
let customerAddress1Input = document.getElementById("input-customer-address1");
let customerAddress1InvalidFeedback = customerAddress1Div
    .getElementsByClassName("invalid-feedback")[0];
let customerAddress1PrependDiv = customerAddress1Div
    .getElementsByClassName("input-group-prepend")[0];
let customerAddress1InputGroupTextDiv = customerAddress1Div
    .getElementsByClassName("input-group-text")[0];

// Global variables - associated with the - Customer Address2 input control
let customerAddress2InputPlaceholder = "";
let customerAddress2Div = document.getElementById("customer-address2-div");
let customerAddress2Input = document.getElementById("input-customer-address2");
let customerAddress2InvalidFeedback = customerAddress2Div
    .getElementsByClassName("invalid-feedback")[0];
let customerAddress2PrependDiv = customerAddress2Div
    .getElementsByClassName("input-group-prepend")[0];
let customerAddress2InputGroupTextDiv = customerAddress2Div
    .getElementsByClassName("input-group-text")[0];

// Global variables - associated with the - Customer Address3 input control
let customerAddress3InputPlaceholder = "";
let customerAddress3Div = document.getElementById("customer-address3-div");
let customerAddress3Input = document.getElementById("input-customer-address3");
let customerAddress3InvalidFeedback = customerAddress3Div
    .getElementsByClassName("invalid-feedback")[0];
let customerAddress3PrependDiv = customerAddress3Div
    .getElementsByClassName("input-group-prepend")[0];
let customerAddress3InputGroupTextDiv = customerAddress3Div
    .getElementsByClassName("input-group-text")[0];

// Global variables - associated with the - Customer Information text area control
let customerInformationTextAreaPlaceholder = "";
let customerInformationDiv = document.getElementById(
    "customer-info-div");
let customerInformationTextArea = document.getElementById(
    "input-customer-info");
let customerInformationInvalidFeedback = customerInformationDiv
    .getElementsByClassName("invalid-feedback")[0];
let customerInformationPrependDiv = customerInformationDiv
    .getElementsByClassName("input-group-prepend")[0];
let customerInformationTextAreaGroupTextDiv = customerInformationDiv
    .getElementsByClassName("input-group-text")[0];

// Reference to the Previous and Next button
let customerCardPreviousButton = document.getElementById("customer-previous");
let customerCardNextButton = document.getElementById("customer-next");

/*****************************************************************************/
/* EVENT LISTENER - CALLBACKS                                                */
/*****************************************************************************/

/* The callback function fired on 'get focus' - for customer 
 * name input control. 
 * @param    
 * @return   
 * */
const resetCustomerNameInputOnGetFocus = () => {

    // Preserve the original placeholder text - the first time the control 
    // gets focus.
    // The customerNameInputPlaceholder variable will be empty - the first time
    // control gets focus
    if (customerNameInputPlaceholder.length === 0) {
        customerNameInputPlaceholder = customerNameInput.placeholder;
    }

    // If the customer name input control has the class SWAP_VALUE 
    // attached - it means that an incorrect value was entered in the field
    // the last time the control had focus.
    if (customerNameInput.classList.contains(SWAP_VALUE) === true) {

        // Remove the class SWAP_VALUE - as the user is preparing to re-enter
        // a valid value
        customerNameInput.classList.remove(SWAP_VALUE);

        // Set the value of the input control to the placeholder value.
        // The erroneous/invalid value was preserved in the placeholder 
        // value - the last time input control lost focus.
        customerNameInput.value = customerNameInput.placeholder;

        // Set the placeholder value of the input control to the original
        // placeholder value of the field.
        customerNameInput.placeholder = customerNameInputPlaceholder;

        // Select the value set in the input field
        customerNameInput.select();

    }

    // Reset all validation related classes
    resetValidation(customerNamePrependDiv, customerNameInputGroupTextDiv);

    // Refresh to original state of the container div
    customerNameDiv.classList.remove("was-validated");

}

/* The callback function fired on 'blur' - for customer name input control.
 * @param    
 * @return   
 * */
const validateCustomerNameInputOnBlur = () => {

    // Check for white spaces
    if (customerNameInput.value.trim().length === 0) {

        // White spaces are present - reset the value to be empty
        customerNameInput.value = "";

        // Update the invalid feedback message
        customerNameInvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_NAME_INVALID_MESSAGE_FEEDBACK;

        invalidateInputControl(customerNamePrependDiv,
            customerNameInputGroupTextDiv);

    } // Check for the length of the name to be not more than 50 characters
    else if (customerNameInput.value.trim().length > 50) {

        // Update the placeholder to display the erroneous/invalid 
        // entered value and reset the input value to blank to invalidate the 
        // input control
        customerNameInput.placeholder = customerNameInput.value;
        customerNameInput.value = "";

        // Update the invalid feedback message
        customerNameInvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_NAME_LENGTH_INVALID_MESSAGE_FEEDBACK;

        // Add the SWAP_VALUE class to the customer name input control
        customerNameInput.classList.add(SWAP_VALUE);

        invalidateInputControl(customerNamePrependDiv,
            customerNameInputGroupTextDiv);


    } else // Passed all validation checks
    {
        validateInputControl(customerNamePrependDiv,
            customerNameInputGroupTextDiv);
    }

    customerNameDiv.classList.add("was-validated");

}

/* The callback function fired on 'get focus' - for customer 
 * mobile input control.
 * @param    
 * @return   
 * */
const resetCustomerMobileInputOnGetFocus = () => {

    // Preserve the original placeholder text - the first time the control
    // gets focus.
    // The customerMobileInputPlaceholder variable will be empty 
    // the first time control gets focus
    if (customerMobileInputPlaceholder.length === 0) {
        customerMobileInputPlaceholder = customerMobileInput.placeholder;
    }

    // If the customer mobile input control has the class SWAP_VALUE 
    // attached - it means that an incorrect value was entered in the field
    // the last time the control had focus.
    if (customerMobileInput.classList.contains(SWAP_VALUE) === true) {

        // Remove the class SWAP_VALUE - as the user is preparing to re-enter
        // a valid value
        customerMobileInput.classList.remove(SWAP_VALUE);

        // Set the value of the input control to the placeholder value.
        // The erroneous/invalid value was preserved in the placeholder 
        // value - the last time input control lost focus.
        customerMobileInput.value = customerMobileInput.placeholder;

        // Set the placeholder value of the input control to the original
        // placeholder value of the field.
        customerMobileInput.placeholder = customerMobileInputPlaceholder;

        // Select the value set in the input field
        customerMobileInput.select();

    }

    // Reset all validation related classes
    resetValidation(customerMobilePrependDiv, customerMobileInputGroupTextDiv);

    // Refresh to original state of the container div
    customerMobileDiv.classList.remove("was-validated");

}

/* The callback function fired on 'blur' - for customer mobile input control. 
 * @param    
 * @return   
 * */
const validateCustomerMobileInputOnBlur = () => {

    // Check for white spaces
    if (customerMobileInput.value.trim().length === 0) {

        // White spaces are present - reset the value to be empty
        customerMobileInput.value = "";

        // Update the invalid feedback message
        customerMobileInvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_MOBILE_INVALID_MESSAGE_FEEDBACK;
        invalidateInputControl(customerMobilePrependDiv,
            customerMobileInputGroupTextDiv);

    } // Check for the length of the mobile no. to be exactly 10 characters
    // and contains only numeric digits starting with a 0
    else if (customerMobileInput.value.trim().length < 10 ||
        customerMobileInput.value.trim().length > 10 ||
        isNaN(parseInt(customerMobileInput.value.trim())) === true ||
        String("0" + parseInt(customerMobileInput.value.trim())) !==
        customerMobileInput.value.trim()) {

        // Update the placeholder to display the erroneous/invalid 
        // entered value and reset the input value to blank to invalidate the 
        // input control
        customerMobileInput.placeholder = customerMobileInput.value;
        customerMobileInput.value = "";

        // Update the invalid feedback message
        customerMobileInvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_MOBILE_DIGITS_INVALID_MESSAGE_FEEDBACK;

        // Add the SWAP_VALUE class to the customer mobile input control
        customerMobileInput.classList.add(SWAP_VALUE);

        invalidateInputControl(customerMobilePrependDiv,
            customerMobileInputGroupTextDiv);

    } else // Passed all validation checks
    {
        validateInputControl(customerMobilePrependDiv,
            customerMobileInputGroupTextDiv);

    }

    customerMobileDiv.classList.add("was-validated");

}

/* The callback function fired on 'get focus' - for customer 
 * Address1 input control.
 * @param    
 * @return   
 * */
const resetCustomerAddress1InputOnGetFocus = () => {

    // Preserve the original placeholder text - the first time the control 
    // gets focus.
    // The customerAddress1InputPlaceholder variable will be empty 
    // the first time
    // control gets focus
    if (customerAddress1InputPlaceholder.length === 0) {
        customerAddress1InputPlaceholder = customerAddress1Input.placeholder;
    }

    // If the customer Address1 input control has the class SWAP_VALUE 
    // attached - it means that an incorrect value was entered in the field
    // the last time the control had focus.
    if (customerAddress1Input.classList.contains(SWAP_VALUE) === true) {

        // Remove the class SWAP_VALUE - as the user is preparing to re-enter
        // a valid value
        customerAddress1Input.classList.remove(SWAP_VALUE);

        // Set the value of the input control to the placeholder value.
        // The erroneous/invalid value was preserved in the placeholder 
        // value - the last time input control lost focus.
        customerAddress1Input.value = customerAddress1Input.placeholder;

        // Set the placeholder value of the input control to the original
        // placeholder value of the field.
        customerAddress1Input.placeholder = customerAddress1InputPlaceholder;

        // Select the value set in the input field
        customerAddress1Input.select();

    }

    // Reset all validation related classes
    resetValidation(customerAddress1PrependDiv,
        customerAddress1InputGroupTextDiv);

    // Refresh to original state of the container div
    customerAddress1Div.classList.remove("was-validated");

}

/* The callback function fired on 'blur' - for customer Address1 input control.
 * @param    
 * @return   
 * */
const validateCustomerAddress1InputOnBlur = () => {

    // Check for white spaces
    if (customerAddress1Input.value.trim().length === 0) {

        // White spaces are present - reset the value to be empty
        customerAddress1Input.value = "";

        // Update the invalid feedback message
        customerAddress1InvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_ADDRESS1_INVALID_MESSAGE_FEEDBACK;

        invalidateInputControl(customerAddress1PrependDiv,
            customerAddress1InputGroupTextDiv);

    } // Check for the length of the Address1 to be not more than 50 characters
    else if (customerAddress1Input.value.trim().length > 50) {

        // Update the placeholder to display the erroneous/invalid
        // entered value and reset the input value to blank to invalidate the
        // input control
        customerAddress1Input.placeholder = customerAddress1Input.value;
        customerAddress1Input.value = "";

        // Update the invalid feedback message
        customerAddress1InvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_ADDRESS1_LENGTH_INVALID_MESSAGE_FEEDBACK;

        // Add the SWAP_VALUE class to the customer Address1 input control
        customerAddress1Input.classList.add(SWAP_VALUE);

        invalidateInputControl(customerAddress1PrependDiv,
            customerAddress1InputGroupTextDiv);


    } else // Passed all validation checks
    {
        validateInputControl(customerAddress1PrependDiv,
            customerAddress1InputGroupTextDiv);
    }

    customerAddress1Div.classList.add("was-validated");

}

/* The callback function fired on 'get focus' - for customer 
 * Address2 input control.
 * @param    
 * @return   
 * */
const resetCustomerAddress2InputOnGetFocus = () => {

    // Remove the required attribute - if present
    customerAddress2Input.removeAttribute("required", "");

    // Preserve the original placeholder text - the first time the control 
    // gets focus.
    // The customerAddress2InputPlaceholder variable will be empty 
    // the first time
    // control gets focus
    if (customerAddress2InputPlaceholder.length === 0) {
        customerAddress2InputPlaceholder = customerAddress2Input.placeholder;
    }

    // If the customer Address2 input control has the class SWAP_VALUE 
    // attached - it means that an incorrect value was entered in the field
    // the last time the control had focus.
    if (customerAddress2Input.classList.contains(SWAP_VALUE) === true) {

        // Remove the class SWAP_VALUE - as the user is preparing to re-enter
        // a valid value
        customerAddress2Input.classList.remove(SWAP_VALUE);

        // Set the value of the input control to the placeholder value.
        // The erroneous/invalid value was preserved in the placeholder 
        // value - the last time input control lost focus.
        customerAddress2Input.value = customerAddress2Input.placeholder;

        // Set the placeholder value of the input control to the original
        // placeholder value of the field.
        customerAddress2Input.placeholder = customerAddress2InputPlaceholder;

        // Select the value set in the input field
        customerAddress2Input.select();

    }

    // Reset all validation related classes
    resetValidation(customerAddress2PrependDiv,
        customerAddress2InputGroupTextDiv);

    // Refresh to original state of the container div
    customerAddress2Div.classList.remove("was-validated");

}

/* The callback function fired on 'blur' - for customer Address2 input control.
 * @param    
 * @return   
 * */
const validateCustomerAddress2InputOnBlur = () => {

    // Check for white spaces
    if (customerAddress2Input.value.trim().length === 0) {

        // White spaces are present - reset the value to be empty
        customerAddress2Input.value = "";

        // Update the invalid feedback message
        customerAddress2InvalidFeedback.innerHTML = "";

        validateInputControl(customerAddress2PrependDiv,
            customerAddress2InputGroupTextDiv);

    } // Check for the length of the Address2 to be not more than 50 characters
    else if (customerAddress2Input.value.trim().length > 50) {

        // Set the required attribute
        customerAddress2Input.setAttribute("required", "");

        // Update the placeholder to display the erroneous/invalid
        // entered value and reset the input value to blank to invalidate the
        // input control
        customerAddress2Input.placeholder = customerAddress2Input.value;
        customerAddress2Input.value = "";

        // Update the invalid feedback message
        customerAddress2InvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_ADDRESS2_INVALID_MESSAGE_FEEDBACK;

        // Add the SWAP_VALUE class to the customer Address2 input control
        customerAddress2Input.classList.add(SWAP_VALUE);

        invalidateInputControl(customerAddress2PrependDiv,
            customerAddress2InputGroupTextDiv);


    } else // Passed all validation checks
    {
        validateInputControl(customerAddress2PrependDiv,
            customerAddress2InputGroupTextDiv);
    }

    customerAddress2Div.classList.add("was-validated");

}

/* The callback function fired on 'get focus' - for customer 
 * Address3 input control.
 * @param    
 * @return   
 * */
const resetCustomerAddress3InputOnGetFocus = () => {

    // Remove the required attribute - if present
    customerAddress3Input.removeAttribute("required", "");

    // Preserve the original placeholder text - the first time the control 
    // gets focus.
    // The customerAddress3InputPlaceholder variable will be empty 
    // the first time
    // control gets focus
    if (customerAddress3InputPlaceholder.length === 0) {
        customerAddress3InputPlaceholder = customerAddress3Input.placeholder;
    }

    // If the customer Address3 input control has the class SWAP_VALUE 
    // attached - it means that an incorrect value was entered in the field
    // the last time the control had focus.
    if (customerAddress3Input.classList.contains(SWAP_VALUE) === true) {

        // Remove the class SWAP_VALUE - as the user is preparing to re-enter
        // a valid value
        customerAddress3Input.classList.remove(SWAP_VALUE);

        // Set the value of the input control to the placeholder value.
        // The erroneous/invalid value was preserved in the placeholder 
        // value - the last time input control lost focus.
        customerAddress3Input.value = customerAddress3Input.placeholder;

        // Set the placeholder value of the input control to the original
        // placeholder value of the field.
        customerAddress3Input.placeholder = customerAddress3InputPlaceholder;

        // Select the value set in the input field
        customerAddress3Input.select();

    }

    // Reset all validation related classes
    resetValidation(customerAddress3PrependDiv,
        customerAddress3InputGroupTextDiv);

    // Refresh to original state of the container div
    customerAddress3Div.classList.remove("was-validated");

}

/* The callback function fired on 'blur' - for customer Address3 input control.
 * @param    
 * @return   
 * */
const validateCustomerAddress3InputOnBlur = () => {

    // Check for white spaces
    if (customerAddress3Input.value.trim().length === 0) {

        // White spaces are present - reset the value to be empty
        customerAddress3Input.value = "";

        // Update the invalid feedback message
        customerAddress3InvalidFeedback.innerHTML = "";

        validateInputControl(customerAddress3PrependDiv,
            customerAddress3InputGroupTextDiv);

    } // Check for the length of the Address3 to be not more than 50 characters
    else if (customerAddress3Input.value.trim().length > 50) {

        // Set the required attribute
        customerAddress3Input.setAttribute("required", "");

        // Update the placeholder to display the erroneous/invalid
        // entered value and reset the input value to blank to invalidate the
        // input control
        customerAddress3Input.placeholder = customerAddress3Input.value;
        customerAddress3Input.value = "";

        // Update the invalid feedback message
        customerAddress3InvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_ADDRESS3_INVALID_MESSAGE_FEEDBACK;

        // Add the SWAP_VALUE class to the customer Address3 input control
        customerAddress3Input.classList.add(SWAP_VALUE);

        invalidateInputControl(customerAddress3PrependDiv,
            customerAddress3InputGroupTextDiv);


    } else // Passed all validation checks
    {
        validateInputControl(customerAddress3PrependDiv,
            customerAddress3InputGroupTextDiv);
    }

    customerAddress3Div.classList.add("was-validated");

}

/* The callback function fired on 'get focus' - for customer 
 * Information textarea control.
 * @param    
 * @return   
 * */
const resetCustomerInformationTextAreaOnGetFocus = () => {

    // Remove the required attribute - if present
    customerInformationTextArea.removeAttribute("required", "");

    // Preserve the original placeholder text - the first time the control 
    // gets focus.
    // The customerInformationTextAreaPlaceholder variable will be empty 
    // the first time control gets focus
    if (customerInformationTextAreaPlaceholder.length === 0) {
        customerInformationTextAreaPlaceholder = customerInformationTextArea
            .placeholder;
    }

    // If the customer Information textarea control has the class SWAP_VALUE 
    // attached - it means that an incorrect value was entered in the field
    // the last time the control had focus.
    if (customerInformationTextArea.classList.contains(SWAP_VALUE) === true) {

        // Remove the class SWAP_VALUE - as the user is preparing to re-enter
        // a valid value
        customerInformationTextArea.classList.remove(SWAP_VALUE);

        // Set the value of the textarea control to the placeholder value.
        // The erroneous/invalid value was preserved in the placeholder 
        // value - the last time textarea control lost focus.
        customerInformationTextArea.value = customerInformationTextArea
            .placeholder;

        // Set the placeholder value of the textarea control to the original
        // placeholder value of the field.
        customerInformationTextArea.placeholder =
            customerInformationTextAreaPlaceholder;

        // Select the value set in the textarea field
        customerInformationTextArea.select();

    }

    // Reset all validation related classes
    resetValidation(customerInformationPrependDiv,
        customerInformationTextAreaGroupTextDiv);

    // Refresh to original state of the container div
    customerInformationDiv.classList.remove("was-validated");

}

/* The callback function fired on 'blur' - for customer Information 
 * textarea control.
 * @param    
 * @return   
 * */
const validateCustomerInformationTextAreaOnBlur = () => {

    // Check for white spaces
    if (customerInformationTextArea.value.trim().length === 0) {

        // White spaces are present - reset the value to be empty
        customerInformationTextArea.value = "";

        // Update the invalid feedback message
        customerInformationInvalidFeedback.innerHTML = "";

        validateInputControl(customerInformationPrependDiv,
            customerInformationTextAreaGroupTextDiv);

    } // Check for the length of the info to be not more than 250 characters
    else if (customerInformationTextArea.value.trim().length > 250) {

        // Set the required attribute
        customerInformationTextArea.setAttribute("required", "");

        // Update the placeholder to display the erroneous/invalid
        // entered value and reset the textarea value to blank to invalidate the
        // textarea control
        customerInformationTextArea.placeholder = customerInformationTextArea.value;
        customerInformationTextArea.value = "";

        // Update the invalid feedback message
        customerInformationInvalidFeedback.innerHTML = LOCK_SELECTION_SURVEY
            .CUSTOMER_ADDITIONAL_INFORMATION_INVALID_MESSAGE_FEEDBACK;

        // Add the SWAP_VALUE class to the customer Information textarea control
        customerInformationTextArea.classList.add(SWAP_VALUE);

        invalidateInputControl(customerInformationPrependDiv,
            customerInformationTextAreaGroupTextDiv);


    } else // Passed all validation checks
    {
        validateInputControl(customerInformationPrependDiv,
            customerInformationTextAreaGroupTextDiv);
    }

    customerInformationDiv.classList.add("was-validated");

}

/* The callback function fired on 'click' - for customer previous button 
 * control.
 * @param    
 * @return   
 * */
const customerCardPreviousButtonClick = (event) => {

    // Hide the status message
    invalidStatusMessageDisplay(false);

    // Transition to lock screen
    let customerInformationCaptureCard = document.getElementById(
        "customer-information-capture");
    let lockInformationCaptureCard = document.getElementById(
        "lock-information-capture");

    window.scrollTo(0, 0);
    customerInformationCaptureCard.classList.toggle('fade-out');

    setTimeout(function() {

        customerInformationCaptureCard.classList.remove('card-fade-in');
        customerInformationCaptureCard.classList.add("card-fade-out");

        lockInformationCaptureCard.classList.remove('card-fade-out');
        lockInformationCaptureCard.classList.add('card-fade-in');

    }, 500);

}

/* The callback function fired on 'click' - for customer next button 
 * control.
 * @param    
 * @return   
 * */
const customerCardNextButtonClick = (event) => {

    // Transition to sales screen
    let customerInformationCaptureCard = document.getElementById(
        "customer-information-capture");
    let salesPersonCaptureCard = document.getElementById(
        "sale-person-information-capture");

    if (allInputsAreValidated("customer-information-capture") === false) {

        // Display the top level warning message
        invalidStatusMessageDisplay(true, "high-severity",
            MESSAGE.MESSAGE_MISSING_INPUT);

        // Apply the valid and invalid styles
        customerNameInput.dispatchEvent(new Event("blur"));
        customerMobileInput.dispatchEvent(new Event("blur"));
        customerAddress1Input.dispatchEvent(new Event("blur"));
        customerAddress2Input.dispatchEvent(new Event("blur"));
        customerAddress3Input.dispatchEvent(new Event("blur"));
        customerInformationTextArea.dispatchEvent(new Event("blur"));


    } else {

        // Hide the status message
        invalidStatusMessageDisplay(false);

        // Save the customer data
        let customerData = {
            customerName: customerNameInput.value,
            customerMobile: customerMobileInput.value,
            customerAddress1: customerAddress1Input.value,
            customerAddress2: customerAddress2Input.value,
            customerAddress3: customerAddress3Input.value,
            customerInformation: customerInformationTextArea.value
        }
        sessionStorage.setItem("customerData", JSON.stringify(customerData));

        // Transition to the sales person screen
        initializeSalesPersonCardControls();

        window.scrollTo(0, 0);
        customerInformationCaptureCard.classList.toggle('fade-out');

        setTimeout(function() {

            customerInformationCaptureCard.classList.remove('card-fade-in');
            customerInformationCaptureCard.classList.add("card-fade-out");

            salesPersonCaptureCard.classList.remove('card-fade-out');
            salesPersonCaptureCard.classList.add('card-fade-in');

        }, 500);

    }

}

/*****************************************************************************/
/* REGISTER EVENT LISTENERS                                                  */
/*****************************************************************************/

// Event listeners registered for the Customer Name input control
customerNameInput.addEventListener("blur", validateCustomerNameInputOnBlur);
customerNameInput.addEventListener("focus", resetCustomerNameInputOnGetFocus);

// Event listeners registered for the Customer Mobile input control
customerMobileInput.addEventListener("blur",
    validateCustomerMobileInputOnBlur);
customerMobileInput.addEventListener("focus",
    resetCustomerMobileInputOnGetFocus);

// Event listeners registered for the Customer Address1 input control
customerAddress1Input.addEventListener("blur",
    validateCustomerAddress1InputOnBlur);
customerAddress1Input.addEventListener("focus",
    resetCustomerAddress1InputOnGetFocus);

// Event listeners registered for the Customer Address2 input control
customerAddress2Input.addEventListener("blur",
    validateCustomerAddress2InputOnBlur);
customerAddress2Input.addEventListener("focus",
    resetCustomerAddress2InputOnGetFocus);

// Event listeners registered for the Customer Address3 input control
customerAddress3Input.addEventListener("blur",
    validateCustomerAddress3InputOnBlur);
customerAddress3Input.addEventListener("focus",
    resetCustomerAddress3InputOnGetFocus);

// Event listeners registered for the Customer Information text area control
customerInformationTextArea.addEventListener("blur",
    validateCustomerInformationTextAreaOnBlur);
customerInformationTextArea.addEventListener("focus",
    resetCustomerInformationTextAreaOnGetFocus);

// Event listeners registered for the Customer previous and next buttons
customerCardPreviousButton.addEventListener("click",
    customerCardPreviousButtonClick);
customerCardNextButton.addEventListener("click", customerCardNextButtonClick);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/