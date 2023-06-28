"use strict";

/* * JavaScript for the file index.html
 *  @author Sanket Rajgarhia
 *  @date   22/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* PAGE COMPONENT ENUMERATIONS                                               */
/*****************************************************************************/

// index page title (EN)
const INDEX = {
    TITLE: "Lock Selection Survey",
};

// Lock selection card
const LOCK_SELECTION_CARD = {
    HEADER: "Lock Model Lookup",
    LABEL_LOCK_MODEL: "Lock Model",
    SUITABILITY_MESSAGE: "This lock is suitable for the following door type",
    LABEL_DOOR_TYPE: "Door Type : ",
    LABEL_DOOR_THICKNESS: "Door Thickness Range : ",
};

// Door specification card
const DOOR_SPECIFICATION_CARD = {
    HEADER: "Door Specification",
    PROCEED_MESSAGE: `Click on the ` +
        `<span id="label-next" class="highlight-text"></span> ` +
        `button and provide the door specification to determine the ` +
        `suitability of a lock model.`,
    LABEL_NEXT: "Next",
};

// Navigation buttons
const NAVIGATION_BUTTONS = {
    SELECT_BUTTON: "     Select     ",
    NEXT_BUTTON: "      Next      "
};

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(INDEX);
Object.freeze(LOCK_SELECTION_CARD);
Object.freeze(DOOR_SPECIFICATION_CARD);
Object.freeze(NAVIGATION_BUTTONS);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/