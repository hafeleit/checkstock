'use strict';

/* * The Sliding Door class.
 *  @author Sanket Rajgarhia
 *  @date   28/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* SLIDING DOOR CLASS IMPLEMENTATION                                         */
/*****************************************************************************/

class SlidingDoor extends Door {

    /* *Constructor
     * @param    {Lock} lockModel                                   Model of the lock for the door
     * @param    {DOOR_MATERIAL} material                           Material of the door
     * @param    {DOOR_CONDITION} condition                         Existing/New door
     * @param    {DOOR_INSTALLATION_LOCATION} installationLocation  Door Installation location
     * @param    {DOOR_THICKNESS_IN_MM} thicknessRange              Thickness range of the door
     * @param    {Unsigned Number} thickness                        Thickness of the door
     * @param    {SWING_DOOR_LEAF/SLIDING_DOOR_LEAF} doorLeaf       Door leaf
     * */
    constructor(lockModel, material, condition, installationLocation,
        thicknessRange, thickness, doorLeaf) {

        super(lockModel, material, condition, installationLocation,
            thicknessRange, thickness, doorLeaf);

    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/