var Admin = (function () {
    function Admin() {
        var $pickers = $('.datetimepicker');
        $pickers.datetimepicker();
        textFit($('.number'));
        this.initCouponDoughnuts();
        alert('hi');
    }
    Admin.prototype.initCouponDoughnuts = function () {
        $('.doughnut').each(function (i, el) {
            var $item = $(el);
            var ctx = $item[0].getContext("2d");
            var used = parseInt($($item.parent()).find('.percent').data('used'));
            var left = parseInt($($item.parent()).find('.percent').data('left'));
            var data = [
                { value: used, color: "#f6303e", label: used + " Used" },
                { value: left, color: "#e1e1e1", label: left + " Left" }
            ];
            setTimeout(function () {
                new Chart(ctx).Doughnut(data, {
                    tooltipTemplate: "<%= label %>",
                    percentageInnerCutout: 77,
                    animationEasing: "easeInOutQuint",
                    showTooltips: false
                });
            }, 325 * i);
        });
    };
    return Admin;
})();
new Admin();
//# sourceMappingURL=admin.js.map