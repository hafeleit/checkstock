"use strict";

/* * JavaScript for the file survey-report.html
 *  @author Sanket Rajgarhia
 *  @date   09/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* PAGE COMPONENT ENUMERATIONS                                               */
/*****************************************************************************/

// Report title (EN)
const SURVEY_REPORT = {
    TITLE: "Lock Selection Survey Report",
    PAGE_HEADING: "Lock Selection Survey Report",
    REPORT_TITLE: "HAFELE LOCK SELECTION REPORT",

    PRINT_BUTTON: "  Print  <span class=\"sr-only\">(current)</span>",
    DOWNLOAD_BUTTON: "Download ",
    EMAIL_BUTTON : "Email"

};

/*****************************************************************************/
/* REPORT_FIELDS ENUMERATIONS                                               */
/*****************************************************************************/

// Report Field labels (EN)
const REPORT_FIELD = {
    CUSTOMER_NAME: "Customer Name",
    CUSTOMER_MOBILE: "Customer Mobile No.",
    CUSTOMER_ADDRESS: "Customer Address",
    CUSTOMER_INFORMATION: "Additional Information",

    SALES_PERSON_ID: "Sales Person ID",
    SALES_PERSON_NAME: "Sales Person Name",
    SALES_PERSON_LOCATION: "Sales Location",

    SURVEY_DETAILS: "Survey Details",

    LOCK_MODEL: "Lock Model",
    LOCK_INSTALLATION_LOCATION: "Installation Location",
    LOCK_INSTALLATION_LOCATION_MESSAGE: "",
    LOCK_DOOR_CONDITION: "Door Condition",
    LOCK_DOOR_CONDITION_MESSAGE: "",
    LOCK_DOOR_RETROFIT: "Existing Door Retrofit",
    LOCK_DOOR_RETROFIT_MESSAGE: "",
    LOCK_DOOR_RETROFIT_CAUTION: "",
    LOCK_DOOR_TYPE: "Door Type",
    LOCK_DOOR_TYPE_MESSAGE: "",
    LOCK_SWING_DOOR_TYPE: "Swing Door Type",
    LOCK_SWING_DOOR_TYPE_MESSAGE: "",
    LOCK_SWING_DOOR_JAMB: "Swing Door Jamb",
    LOCK_SWING_DOOR_JAMB_MESSAGE: "",
    LOCK_SWING_DOOR_JAMB_CAUTION: "",
    LOCK_DOOR_THICKNESS: "Door Thickness",
    LOCK_DOOR_THICKNESS_MESSAGE: "",
    LOCK_DOOR_THICKNESS_INPUT: "Door Thickness",
    LOCK_DOOR_THICKNESS_INPUT_MESSAGE: "",
    LOCK_THICKNESS_MM: "mm",
    LOCK_DOOR_MATERIAL: "Door Material",
    LOCK_DOOR_MATERIAL_MESSAGE: "",
    LOCK_DOOR_MATERIAL_CAUTION: "",
    LOCK_DOOR_LEAF: "Door Leaf",
    LOCK_DOOR_LEAF_MESSAGE: ""
};

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(SURVEY_REPORT);
Object.freeze(REPORT_FIELD);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/