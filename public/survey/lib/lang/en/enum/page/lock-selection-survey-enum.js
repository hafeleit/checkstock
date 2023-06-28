"use strict";

/* * JavaScript for the file survey-report.html
 *  @author Sanket Rajgarhia
 *  @date   17/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* PAGE COMPONENT ENUMERATIONS                                               */
/*****************************************************************************/

// Lock selection survey (EN)
const LOCK_SELECTION_SURVEY = {
    TITLE: "Lock Selection Survey",
    PAGE_HEADING: "Lock Selection Survey",

    LOCK_CARD_HEADING: "Door And Lock Information",
    LOCK_MODEL: "Lock Model",
    LOCK_INSTALLATION_LOCATION: "Installation Location",
    LOCK_DOOR_CONDITION: "Door Condition",
    LOCK_DOOR_RETROFIT: "Existing Door Retrofit",
    LOCK_DOOR_TYPE: "Door Type",
    LOCK_SWING_DOOR_TYPE: "Swing Door Type",
    LOCK_SWING_DOOR_JAMB: "Swing Door Jamb",
    LOCK_DOOR_THICKNESS: "Door Thickness",
    LOCK_DOOR_THICKNESS_INPUT: "Door Thickness In Millimeter (mm)",
    LOCK_DOOR_MATERIAL: "Door Material",
    LOCK_DOOR_LEAF: "Door Leaf",

    LOCK_DOOR_LEAF_GROUP_LABEL_START: "",
    LOCK_DOOR_LEAF_GROUP_LABEL_SWING_DOOR: "SWING DOOR LEAF",
    LOCK_DOOR_LEAF_GROUP_LABEL_SLIDING_DOOR: "SLIDING DOOR LEAF",

    CUSTOMER_CARD_HEADING: "Customer Information",
    CUSTOMER_NAME_PLACEHOLDER: "Customer name",
    CUSTOMER_NAME_INVALID_MESSAGE_FEEDBACK: "Customer name cannot be blank.",
    CUSTOMER_NAME_LENGTH_INVALID_MESSAGE_FEEDBACK: "Name cannot contain more " +
        "than 50 characters.",
    CUSTOMER_MOBILE_PLACEHOLDER: "Mobile No. (10 digit)",
    CUSTOMER_MOBILE_INVALID_MESSAGE_FEEDBACK: "Mobile number cannot be blank.",
    CUSTOMER_MOBILE_DIGITS_INVALID_MESSAGE_FEEDBACK: "Mobile No. must contain " +
        "10 digits, starting with a 0.",
    CUSTOMER_ADDRESS1_PLACEHOLDER: "Customer Address - Line 1",
    CUSTOMER_ADDRESS1_INVALID_MESSAGE_FEEDBACK: "Address cannot be blank.",
    CUSTOMER_ADDRESS1_LENGTH_INVALID_MESSAGE_FEEDBACK: "Address Line 1 cannot " +
        "contain more than 50 characters.",
    CUSTOMER_ADDRESS2_PLACEHOLDER: "Customer Address - Line 2",
    CUSTOMER_ADDRESS2_INVALID_MESSAGE_FEEDBACK: "Address Line 2 cannot contain more " +
        "than 50 characters.",
    CUSTOMER_ADDRESS3_PLACEHOLDER: "Customer Address - Line 3",
    CUSTOMER_ADDRESS3_INVALID_MESSAGE_FEEDBACK: "Address Line 3 cannot contain more " +
        "than 50 characters.",
    CUSTOMER_ADDITIONAL_INFORMATION_PLACEHOLDER: "Additional Information",
    CUSTOMER_ADDITIONAL_INFORMATION_INVALID_MESSAGE_FEEDBACK: "Additional " +
        "Information cannot contain more than 250 characters.",

    SALES_PERSON_CARD_HEADING: "Sales Person Information",
    SALES_PERSON_ID_PLACEHOLDER: "Sales Person ID",
    SALES_PERSON_ID_INVALID_MESSAGE_FEEDBACK: "Sales Person ID cannot be blank.",
    SALES_PERSON_ID_LENGTH_INVALID_MESSAGE_FEEDBACK: "Sales Person ID cannot " +
        " contain more than 50 characters.",
    SALES_PERSON_NAME_PLACEHOLDER: "Sales Person Name",
    SALES_PERSON_NAME_INVALID_MESSAGE_FEEDBACK: "Sales Person name cannot be blank.",
    SALES_PERSON_NAME_LENGTH_INVALID_MESSAGE_FEEDBACK: "Name cannot contain more " +
        "than 50 characters.",
    SALES_PERSON_LOCATION_PLACEHOLDER: "Location Information",
    SALES_PERSON_LOCATION_INVALID_MESSAGE_FEEDBACK: "Location Information " +
        "cannot contain more than 150 characters."

};

// Navigation buttons
const NAVIGATION_BUTTONS = {
    LOCK_PREVIOUS_BUTTON: "    Previous    ",
    LOCK_NEXT_BUTTON: "      Next      "
}

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(LOCK_SELECTION_SURVEY);
Object.freeze(NAVIGATION_BUTTONS);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/