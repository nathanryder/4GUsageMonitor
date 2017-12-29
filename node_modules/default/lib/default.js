/*
 * default
 * https://github.com/safareli/default
 *
 * Copyright (c) 2014 Irakli Safareli
 * Licensed under the MIT license.
 */

'use strict';

Object.prototype.default = function(toCheck){
    if(toCheck == null){
        return this;
    }
    
    if(typeof toCheck === "object" && typeof this === "object"){
        for (var key in this) {
            if (this.hasOwnProperty(key) && toCheck[key] == null){
               toCheck[key] = this[key];
            }
        }
    }
    return toCheck;
};