'use strict';

/* * The Message Enumeration Values (EN).
 *  @author   Sanket Rajgarhia
 *  @date 05/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 *  @language: en
 * */

/*****************************************************************************/
/* MESSAGE ENUMERATION (EN)                                                  */
/*****************************************************************************/

// Messages
const MESSAGE = {
    MESSAGE_FAILURE: "Sorry, the selected lock cannot be installed!",
    MESSAGE_DOOR_TYPE_AND_LOCK_MISMATCH: "This door type is not suitable " +
        "for the selected lock type.",
    MESSAGE_JAMB_AND_LOCK_TYPE_MISMATCH: "This lock is not recommended " +
        "for double doors.",
    MESSAGE_DOOR_THICKNESS_AND_LOCK_MISMATCH: "The selected door lock " +
        "cannot be installed on a door of this thickness.",
    MESSAGE_MATERIAL_FAILURE: "Sorry, a lock cannot be installed on a door " +
        "comprising of this material!",
    MESSAGE_DOOR_LEAF_AND_DOOR_TYPE_MISMATCH: "The selected door leaf is " +
        "not compatible with the selected door type.",
    MESSAGE_DOOR_LEAF_FRAME_THICKNESS_INADEQUATE: "A door lock cannot be " +
        "installed on the selected swing door stile.",
    MESSAGE_DOOR_LEAF_THICKNESS_INADEQUATE: "A door lock cannot be " +
        "installed on the selected sliding door stile.",

    MESSAGE_MISSING_INPUT: "Please provide the required information -" +
        " marked in red."
}

// Caution messages
const CAUTION = {
    EXISTING_DOOR_RETROFIT_CAUTION: "CAUTION :\n" +
        "Installer may need to fill old holes or previous drillings " +
        "with silicon or wood filler.",
    EXISTING_DOOR_RETROFIT_RIM_LOCK_CAUTION: "CAUTION: \n" +
        "This surface mounted rim lock should install above the existing lock set.",
    SWING_DOOR_JAMB_CAUTION: "CAUTION: \n" +
        "Installer may need to cut or engrave where to install the " +
        "striking plate at the door jam, in order to make the door " +
        "lock work properly. ",
    DOOR_MATERIAL_CAUTION: "CAUTION: \n" +
        "The steel door MUST be supplied with all metal cut-outs and drills specifically for our lock. The installer will only handle the assembling and system settings."
}

/*****************************************************************************/
/* FREEZE - TO EMULATE ENUMERATION                                           */
/*****************************************************************************/

// Prevent addition of properties to the json Object
Object.freeze(MESSAGE);
Object.freeze(CAUTION);

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/