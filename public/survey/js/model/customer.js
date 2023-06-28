'use strict';

/* * The Customer class.
 *  @author Sanket Rajgarhia
 *  @date   30/03/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* CUSTOMER CLASS IMPLEMENTATION                                             */
/*****************************************************************************/

class Customer {

    /* *Constructor
     * @param    {String} customerName          Name of the customer
     * @param    {String} phoneNumber           10 Digit Phone Number of the customer
     * @param    {String} address               150 characters address
     * @param    {String} additionalInformation 250 characters additional information
     * */
    constructor(customerName, phoneNumber, address, additionalInformation) {

        this._customerName = customerName;
        this._phoneNumber = phoneNumber;
        this._address = address;
        this._additionalInformation = additionalInformation;

    }

    /* Get the customer name
     * @return {String} Customer name
     */
    get customerName() {
        return this._customerName;
    }

    /* Set the customer name
     * @param   {String} customerName  Name of the customer
     */
    set customerName(customerName) {
        this._customerName = customerName;
    }

    /* Get the customer phone number
     * @return  {String} Customer phone number
     */
    get phoneNumber() {
        return this._phoneNumber;
    }

    /* Set the phone number
     * @param   {String} phoneNumber    10 Digit Phone Number of the customer
     */
    set phoneNumber(phoneNumber) {
        this._phoneNumber = phoneNumber;
    }

    /* Get the customer address
     * @return  {String} Customer address
     */
    get address() {
        return this._address;
    }

    /* Set the address
     * @param   {String} address   150 characters address
     */
    set address(address) {
        this._address = address;
    }

    /* Get the additional information
     * @return  {String} Additional information
     */
    get additionalInformation() {
        return this._additionalInformation;
    }

    /* Set the additional information
     * @param   {String} additionalInformation  250 characters additional information
     */
    set additionalInformation(additionalInformation) {
        this._additionalInformation = additionalInformation;
    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/