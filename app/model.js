/*
 * It gets the pageId.html file and then puts the data into the app div
 * pageId - This is the id of the page that you want to change to.
 */
export function changePage(pageId) {
    /* Using the jQuery get method to get the pageId.html file and then it is using the jQuery html
    method to put the data into the app div. */
    $.get(`pages/${pageId}.html`, function(data) {
        $("#app").html(data);
    })
};
