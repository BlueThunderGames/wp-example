var URLcheck =  window.location.host;
var restUrl = null;

//fetch json data from api
function getJsonData() {
    return jQuery.ajax({
        method: "GET",
        cache: false,
        type: "text/json",
        url: restUrl,
        success: (data) => {
            renderJsonData(data, getAllObjKeys(data));
        },
    });
}

function renderJsonData(data, keys) {
    var _data = data;
    for (var _i in keys) {
        if (
            typeof getJsonValue(keys[_i], _data) === "object" &&
            getJsonValue(keys[_i], _data) !== null
        ) {

            var arrObj = getJsonValue(keys[_i], _data);
            var arrayLength = getJsonValue(keys[_i], _data).length;

            // check if the specific top level object property has an array of objects
            if (!arrayLength) {
                //it is only a nested object - no arrays
                var sKeys = getAllObjKeys(getJsonValue(keys[_i], _data));
                for (var _ix in sKeys) {
                    var _dataKey = "{[data." + keys[_i] + "." + sKeys[_ix] + "]}";
                    jQuery('[class="r_data"]').each((_, v) => {
                        var text = jQuery(v).text();
                        if (text === _dataKey && keys) {
                            var new_text = text.replace(
                                _dataKey,
                                getJsonValue(sKeys[_ix], getJsonValue(keys[_i], _data))
                            );
                            jQuery(v).text(new_text);
                        }
                    });
                }
                // this top level object is an array of objects
            } else {
                for (var irarray in arrObj) {
                    var sKeys = getAllObjKeys(arrObj[irarray]);
                    for (var _ix in sKeys) {
                        var _dataKey = "{[data." + keys[_i] + "[" + irarray + "]." + sKeys[_ix] + "]}";
                        jQuery('[class="r_data"]').each((_, v) => {
                            var text = jQuery(v).text();
                            if (text === _dataKey && keys) {
                                var new_text = text.replace(
                                    _dataKey,
                                    getJsonValue(sKeys[_ix], arrObj[irarray])
                                );
                                jQuery(v).text(new_text);
                            }
                        });
                    }
                }
            }
            // the top level object property is only a property value (no object or array of objects)
        } else {
            var _dataKey = "{[data." + keys[_i] + "]}";
            jQuery('[class="r_data"]').each((_, v) => {
                var text = jQuery(v).text();
                if (text === _dataKey && keys) {
                    var new_text = text.replace(_dataKey, getJsonValue(keys[_i], _data));
                    jQuery(v).text(new_text);
                }
            });
        }
    }
    jQuery('.r_data').each(function() {
    var thisText = jQuery(this).text();
    if (thisText.includes("{[")) {
        jQuery(this).text("N/A");
    }
});
}

//on document ready lets call function to parse the json response
jQuery(document).ready(() => {

    if (URLcheck.includes('wilmingtontrust.com') || true) {
        // Url to api - response - published
        console.log("qs: " + qs("id"));
        //restUrl = "https://api.mtb.com/wtris/v1/fund?id=" + qs("id");
        restUrl = "https://cluster-unitvalue-api-unitvalue-api.azuremicroservices.io/v1/fund?id=" + qs("id");
        //restUrl = "https://24197306.fs1.hubspotusercontent-na1.net/hubfs/24197306/FactSheets/fund_28.json";
    } else {
        // Url to api - response during editing
        restUrl = "https://apiwtris.wilmingtontrust.com/v1/fund?id=" + qs("id");
    }

    if (!!restUrl) {
        //by default hide all dyanmic elements - show all elements when json is parsed and ready to be displayed
        jQuery('[class="r_data"]').hide();
        jQuery.when(getJsonData()).done(() => {
            jQuery('[class="r_data"]').show();
        });
    }

});

// ============ UTILITIES ==============
function getAllObjKeys(data) {
    var temp = data;
    var keys = [];
    for (var k in temp) keys.push(k);
    return keys;
}

function getJsonValue(key, data) {
    var val;
    for (var _key in data) {
        if (key === _key) {
            val = data[_key];
        }
    }
    return val;
}

//get query parameter for fund id
function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]" + key + "=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}