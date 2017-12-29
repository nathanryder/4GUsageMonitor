/*
 * default
 * https://github.com/safareli/default
 *
 * Copyright (c) 2014 Irakli Safareli
 * Licensed under the MIT license.
 */

'use strict';

require('chai').should();
require('../lib/default');

describe('default',function(){
    var tony = "tony",
        bob = "bob",
        user = {
            userName:'jhon555',
            gender:'male'
        }, userDefaults = {
            gender:'ather',
            type:'free'
        };

    it('should work with strings',function(){
        tony.default(bob).should.equal(bob);
        tony.default('').should.equal('');
        tony.default(null).should.equal(tony);
        tony.default(undefined).should.equal(tony);
    });

    it('should work with numbers',function(){
        (25).default(10).should.equal(10);
        (25).default(null).should.equal(25);
        (25).default(undefined).should.equal(25);
    });

    it('should work with objects',function(){
        user.default(userDefaults).should.deep.equal({
            userName:'jhon555',
            gender:'ather',
            type:'free'
        });
        user.default(null).should.equal(user);
        user.default(undefined).should.equal(user);
    });
    
});