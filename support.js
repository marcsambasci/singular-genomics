(function ($) {
    const submenuIcon = $(".submenu-title-container > .menu-icon");
    const supportDocList = $(".sd-section-document-list");
    const toggleButton = $(".toggleButton");

    submenuIcon.click(function () {
        const submenuTitle = $(this).parents(".submenu-title");
        submenuTitle.toggleClass("open");
    });

    // Initial setup for each list
    supportDocList.each(function() {
        $(this).find("li:gt(4)").hide(); // Hide items beyond the first 5
        if ($(this).find("li").length <= 5) {
            $(this).next().children(".toggleButton").hide(); // Hide button if not needed
        }
    });

    // Button click event for each button
    toggleButton.click(function() {
        var $button = $(this);
        var $list = $button.parent().prev(".sd-section-document-list");

        if ($button.text() === "Show more") {
            $list.find("li").show();
            $button.text("Show less");
        } else {
            $list.find("li:gt(4)").hide();
            $button.text("Show more");
        }

        return false;
    });
})(jQuery);
