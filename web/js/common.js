$(document).ready(function () {

    $('#courseCategories').change(function () {
        $('#filtersForm').submit();
    });
    $('#courseLanguages').change(function () {
        $('#filtersForm').submit();
    });
    $('#courseAuthors').change(function () {
        $('#filtersForm').submit();
    });
});