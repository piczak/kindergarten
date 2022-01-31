var daysBetweenDates = function(d1, d2) {
    var diffDays, firstDate, oneDay, secondDate;
    oneDay = 24 * 60 * 60 * 1000;
    firstDate = Date.parse(d1);
    secondDate = Date.parse(d2);
    diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
    return diffDays;
};