'use strict';

/* * The Sales class.
 *  @author Sanket Rajgarhia
 *  @date   30/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* SALES CLASS IMPLEMENTATION                                                */
/*****************************************************************************/

class Sales {

    /* *Constructor
     * @param    {String} salesPersonId     ID of the sales person
     * @param    {String} salesPersonName   Name of the sales person
     * @param    {String} salesLocation     150 characters sales location/address
     * */
    constructor(salesPersonId, salesPersonName, salesLocation) {

        this._salesPersonId = salesPersonId;
        this._salesPersonName = salesPersonName;
        this._salesLocation = salesLocation;

    }

    /* Get the ID of the sales person
     * @return  {String}    ID of the sales person
     */
    get salesPersonId() {
        return this._salesPersonId;
    }

    /* Set the ID of the sales person
     * @param  {String} salesPersonId   ID of the sales person
     */
    set salesPersonId(salesPersonId) {
        this._salesPersonId = salesPersonId;
    }

    /* Get the name of the sales person
     * @return  {String}    Name of the sales person
     */
    get salesPersonName() {
        return this._salesPersonName;
    }

    /* Set the name of the sales person
     * @param    {String} salesPersonName   Name of the sales person
     */
    set salesPersonName(salesPersonName) {
        this.salesPersonName = salesPersonName;
    }

    /* Get the location of the sale
     * @return  {String}    150 characters sales location/address
     */
    get salesLocation() {
        return this._salesLocation;
    }

    /* Set the location of the sale
     * @param    {String} salesLocation     150 characters sales location/address
     */
    set salesLocation(salesLocation) {
        this._salesLocation = salesLocation;
    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/