/**
 * The toLocaleString() method returns a Date object as a string, using locale settings.
 * The default language depends on the locale setup on your computer.
 *
 * https://www.w3schools.com/jsref/jsref_tolocalestring.asp
 *
 * @param {Date} date
 * @param {Object} options
 * @returns
 */
function formatDate(date, options = {}) {
    const convert = new Date(date)
    return convert.toLocaleString("pt-BR", options ?? {});
}

export { formatDate }
