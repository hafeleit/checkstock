'use strict';

/* * The Lock compatibility with specific door types of specified range
 *  of thickness.
 *  @author   Sanket Rajgarhia
 *  @date 03/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* FUNCTIONS                                                                 */
/*****************************************************************************/

/* The function forms an object containing  the door type and door thickness 
 * range - determined by the lock model value.
 * name input control. 
 * @param    {LOCK_MODEL} lockModel The model of the lock
 * @return   {Object}   An Object containing doorType and doorThickness
 * */
const lockCompatibility = (lockModel) => {

    switch (lockModel) {

        case LOCK_MODEL.DC1000:
        case LOCK_MODEL.ER4900:
        case LOCK_MODEL.ER5100:
            return {
                doorType: DOOR_TYPE.SWING_DOOR,
                    doorThickness: DOOR_THICKNESS_IN_MM.MM_30_TO_50
            };
        case LOCK_MODEL.ER5200:
            return {
                doorType: DOOR_TYPE.SWING_DOOR + "/" + DOOR_TYPE.SLIDING_DOOR,
                    doorThickness: DOOR_THICKNESS_IN_MM.MM_30_TO_50
            };

        case LOCK_MODEL.DH2000:
        case LOCK_MODEL.DH2100:
            return {
                doorType: DOOR_TYPE.SWING_DOOR,
                    doorThickness: DOOR_THICKNESS_IN_MM.MM_32_TO_50
            };
        case LOCK_MODEL.DL6500:
        case LOCK_MODEL.DL7000:
        case LOCK_MODEL.DL7100:
        case LOCK_MODEL.DL7900:
        case LOCK_MODEL.EL6000:
        case LOCK_MODEL.EL7200:
        case LOCK_MODEL.EL7500:
            return {
                doorType: DOOR_TYPE.SWING_DOOR,
                    doorThickness: DOOR_THICKNESS_IN_MM.MM_35_TO_50
            };


        case LOCK_MODEL.DL7600:
        case LOCK_MODEL.PP8100:
        case LOCK_MODEL.PP9000:
        case LOCK_MODEL.PP9100:
            return {
                doorType: DOOR_TYPE.SWING_DOOR,
                    doorThickness: DOOR_THICKNESS_IN_MM.MM_35_TO_60
            };

        case LOCK_MODEL.DL6600:
            return {
                doorType: DOOR_TYPE.SWING_DOOR + "/" + DOOR_TYPE.SLIDING_DOOR,
                    doorThickness: DOOR_THICKNESS_IN_MM.MM_35_TO_90
            };
        default:
            return {
                doorType: "",
                    doorThickness: ""
            }

    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/