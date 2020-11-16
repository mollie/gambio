$(document).ready(function () {
    let tabs = $('.mollie-tab');
    let contents = $('.mollie-tab-content');
    initTabs();

    function initTabs() {
        hideAll();
        setActive(tabs.first());
    }

    tabs.click(function() {
        hideAll();
        setActive($(this));

        return false;
    });

    function hideAll() {
        tabs.removeClass('active-tab');
        contents.hide();
    }

    function setActive(activatedTab) {
        activatedTab.addClass('active-tab');
        let action  = activatedTab.attr("data-action");
        let activeTabSelector = '.mollie-table-content[data-action="' + action + '"]';
        $(activeTabSelector).fadeIn();
        $(document).trigger('mollie-tab-changed-event', [action]);
    }
});
