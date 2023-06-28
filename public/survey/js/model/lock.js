'use strict';

/* * The Lock class.
 *  @author Sanket Rajgarhia
 *  @date   03/04/2022 (dd/mm/yyyy)
 *  @version 1.0
 * */

/*****************************************************************************/
/* LOCK CLASS IMPLEMENTATION                                                */
/*****************************************************************************/

class Lock {

    /* *Constructor
     * @param    {String} model     Model of the lock
     * */
    constructor(model) {

        this._model = model;

    }

    /* Get the lock model
     * @return  {String}    Model of the lock
     */
    get model() {
        return this._model;
    }

    /* Set the lock model
     * @param    {String} model     Model of the lock
     */
    set model(model) {
        this._model = model;
    }

}

/*****************************************************************************/
/* END OF FILE                                                               */
/*****************************************************************************/