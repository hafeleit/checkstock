'use strict';

/* * The generic Door class.
 *  @author Sanket Rajgarhia
 *  @date   30/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* DOOR CLASS IMPLEMENTATION                                                 */
/*****************************************************************************/

class Door {

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

        this._lockModel = lockModel;
        this._material = material;
        this._condition = condition;
        this._installationLocation = installationLocation;
        this._thicknessRange = thicknessRange;
        this._thickness = thickness;
        this._doorLeaf = doorLeaf;

    }

    /* Get the lock model of the door
     * @return {Lock}  Lock model of the door
     */
    get lockModel() {
        return this._lockModel;
    }

    /* Set the lock model of the door
     * @param    {Lock} lockModel   Lock model of the door
     */
    set lockModel(lockModel) {
        this._lockModel = lockModel;
    }

    /* Get the material of the door
     * @return {DOOR_MATERIAL}  Material of the door
     */
    get material() {
        return this._material;
    }

    /* Set the material of the door
     * @param    {DOOR_MATERIAL} material   Material of the door
     */
    set material(material) {
        this._material = material;
    }

    /* Get the condition of the door
     * @return {DOOR_CONDITION}     Existing/New door
     */
    get condition() {
        return this._condition;
    }

    /* Set the condition of the door
     * @param    {DOOR_CONDITION} condition     Existing/New door
     */
    set condition(condition) {
        this._condition = condition;
    }

    /* Get the installation location of the door
     * @return {DOOR_INSTALLATION_LOCATION}     Door Installation location
     */
    get installationLocation() {
        return this._installationLocation;
    }

    /* Set the installation location of the door
     * @param    {DOOR_INSTALLATION_LOCATION}   Door Installation location
     */
    set installationLocation(installationLocation) {
        this._installationLocation = installationLocation;
    }

    /* Get the thickness range of the door
     * @return {DOOR_THICKNESS_IN_MM}     Thickness range of the door
     */
    get thicknessRange() {
        return this._thicknessRange;
    }

    /* Set the thickness range of the door
     * @param   {DOOR_THICKNESS_IN_MM} thicknessRange     Thickness range of the door
     */
    set thicknessRange(thicknessRange) {
        this._thicknessRange = thicknessRange;
    }

    /* Get the thickness of the door
     * @return {Unsigned Number}     Thickness of the door
     */
    get thickness() {
        return this._thickness;
    }

    /* Set the thickness of the door
     * @param    {Unsigned Number} thickness     Thickness of the door
     */
    set thickness(thickness) {
        this._thickness = thickness;
    }

    /* Get the door leaf
     * @return {SWING_DOOR_LEAF/SLIDING_DOOR_LEAF}     Door leaf
     */
    get doorLeaf() {
        return this._doorLeaf;
    }

    /* Set the door leaf of the door
     * @param    {SWING_DOOR_LEAF/SLIDING_DOOR_LEAF} doorLeaf     Door Leaf
     */
    set doorLeaf(doorLeaf) {
        this.doorLeaf = doorLeaf;
    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/