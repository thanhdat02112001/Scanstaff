// Copyright (c) Alex Ellis 2017. All rights reserved.
// Licensed under the MIT license. See LICENSE file in the project root for full license information.

"use strict"

const getStdin = require('get-stdin');
const fs = require('fs');
const handler = require('./function/handler');
const { exec } = require("child_process");

getStdin().then(val => {
    const cb = (err, res) => {
        if (err) {
            return console.error(err);
        }
        if (!res) {
            return;
        }
        if (Array.isArray(res) || isObject(res)) {
            console.log(JSON.stringify(res));
        } else {
            // process.stdout.write(res);
            let data = JSON.parse(val);
            fs.writeFile(`solution_${data.sid}.js`, data.body, function () {});
            exec(`node solution_${data.sid}.js`, (error, stdout, stderr) => {
                if (error) {
                    console.log(`${error.message}`);
                    return;
                }
                if (stderr) {
                    console.log(`${stderr}`);
                    return;
                }
                console.log(stdout);
            });
        }
    } // cb ...

    const result = handler(val, cb);
    if (result instanceof Promise) {
        result
            .then(data => cb(undefined, data))
            .catch(err => cb(err, undefined))
            ;
    }
}).catch(e => {
    console.error(e.stack);
});

const isObject = (a) => {
    return (!!a) && (a.constructor === Object);
};