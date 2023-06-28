'use strict';

/* * The Swing Door class.
 *  @author Sanket Rajgarhia
 *  @date   28/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* SWING DOOR CLASS IMPLEMENTATION                                           */
/*****************************************************************************/

class SwingDoor extends Door {


    /* *Constructor
     * @param    {Lock} lockModel                                   Model of the lock for the door
     * @param    {DOOR_MATERIAL} material                           Material of the door
     * @param    {DOOR_CONDITION} condition                         Existing/New door
     * @param    {DOOR_INSTALLATION_LOCATION} installationLocation  Door Installation location
     * @param    {DOOR_THICKNESS_IN_MM} thicknessRange              Thickness range of the door
     * @param    {Unsigned Number} thickness                        Thickness of the door
     * @param    {SWING_DOOR_LEAF/SLIDING_DOOR_LEAF} doorLeaf       Door leaf
     * @param    {SWING_DOOR_TYPE} type                           Swing door type
     * @param    {SWING_DOOR_JAMB} doorJamb                       Swing door jamb
     * */
    constructor(lockModel, material, condition, installationLocation,
        thicknessRange, thickness, doorLeaf, type, doorJamb) {

        super(lockModel, material, condition, installationLocation,
            thicknessRange, thickness, doorLeaf, type, doorJamb);

        this._type = type;
        this._doorJamb = doorJamb;

    }

    /* Get the swing door type
     * @return {SWING_DOOR_TYPE}  Swing door type
     */
    get type() {
        return this._type;
    }

    /* Set the swing door type
     * @param    {SWING_DOOR_TYPE} type   Swing door type
     */
    set type(type) {
        this._type = type;
    }

    /* Get the swing door jamb
     * @return {SWING_DOOR_JAMB}     Swing door jamb
     */
    get doorJamb() {
        return this._doorJamb;
    }

    /* Set the swing door jamb
     * @param    {SWING_DOOR_JAMB} doorJamb     Swing door jamb
     */
    set doorJamb(doorJamb) {
        this._doorJamb = doorJamb;
    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/