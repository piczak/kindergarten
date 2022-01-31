/**
 * @param uri
 * @param parameter
 * @param value
 * @param isMultiple
 * @returns {string}
 */
function addOrUpdateUriParameter(uri, parameter, value, isMultiple) {
    var isMultipleQuery = isMultiple || false;
    var new_url = normalizeAmpersand(uri);
    
    new_url = URI(new_url).normalizeQuery();

    if (!isMultipleQuery && new_url.hasQuery(parameter)) {
        new_url.removeQuery(parameter);
    } else if (isMultipleQuery && new_url.hasQuery(parameter)) {
        new_url.removeQuery(parameter, value);
    }


    if (value != '') {
        new_url = new_url.addQuery(parameter, value);
    }

    return new_url.toString();
}

/**
 * @param uri
 * @param parameter
 * @param value
 * @param isMultiple
 * @returns {string}
 */
function removeUriParameter(uri, parameter, value, isMultiple)
{
    var isMultipleQuery = isMultiple || false;
    var new_url = normalizeAmpersand(uri);

    new_url = URI(new_url).normalizeQuery();

    if (!isMultipleQuery && new_url.hasQuery(parameter)) {
        new_url.removeQuery(parameter);
    } else if (isMultipleQuery && new_url.hasQuery(parameter)) {
        new_url.removeQuery(parameter, value);
    }

    return new_url.toString();
}

/**
 * @param {*} string 
 */
function normalizeAmpersand(string) {
    return string.replace(/&amp;/g, "&").replace(/amp%3B/g, "");
}
