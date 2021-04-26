window.MainComponent = function () {
    this.isLoadSerials = false;

    this.serialsContainer = $('#anime-section');
    this.serialsEmptyContainer = $('#serials-empty-container');
    this.filterContainer = $('#filter-container')
    this.page = 1;

    this.filter = {};

    this.init();
}

window.MainComponent.prototype = {
    init: function () {
        $(this.filterContainer).find('select').on('change', $.proxy(this.onFilterChange, this));
    },
    loadSerials: function () {
        if (this.emptyResponse) {
            return;
        }

        this.isLoadSerials = true;
        console.log('Отправляем запрос, страничка ' + this.page);
        $.ajax({
            type: "GET",
            url: baseAPIURL + 'serial/',
            data: {
                page: 1,
                filter: this.filter,
                sortField: 'views|DESC'
            },
            success: function (data) {
                if (data.data.length === 0) {
                    MainComponentApp.serialsEmptyContainer.show();
                } else if (data.data.length > 0) {
                    MainComponentApp.serialsEmptyContainer.hide();
                    data.data.forEach(function (element) {
                        let preparedNode = MainComponentApp.prepareSerialNode(element);
                        MainComponentApp.serialsContainer.append(preparedNode);
                    });
                }
                MainComponentApp.isLoadSerials = false;
            },
            error: function () {
                $.toast({
                    text: "Возникла ошибка при отправке запроса. \n Попробуйте позже",
                    bgColor: '#c0392b',              // Background color for toast
                    textColor: '#bdc3c7',            // text color
                    allowToastClose: true,       // Show the close button or not
                    position: 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    },

    onFilterChange: function () {
        this.filter = {};
        this.serialsContainer.empty();
        this.filterContainer.find('select').each(function () {
            if ($(this).val() === null) {
                return;
            }
            let propName = $(this).data('name');
            let propValue = $(this).val();
            if (propValue === 'empty') {
                return;
            }
            MainComponentApp.filter[propName] = propValue;
        });
        this.loadSerials();
    },

    prepareSerialNode: function (element) {
        let categories = element.categories.join(', ');

        return '<div class="anime-list__block__section__item">\n' +
            '                                <a href="' + animePlayerUrl + element.id + '">\n' +
            '                                    <img src="' + element.posterURL + '" class="anime-list__block__section__item__image">\n' +
            '                                </a>\n' +
            '                                <div class="anime-list__block__section__item__detail">\n' +
            '                                    <div class="anime-list__block__section__item__detail__header">\n' +
            '                                        <h2><a href="' + animePlayerUrl + element.id + '">' + element.name + '</a>\n' +
            '                                        </h2>\n' +
            '                                        <h2>\n' +
            '                                            <a href="' + animePlayerUrl + element.id + '">' + element.nameOrig + '</a>\n' +
            '                                        </h2>\n' +
            '                                    </div>\n' +
            '                                    <div class="anime-list__block__section__item__detail__genre">\n' +
            '                                        <h3>ЖАНРЫ:\n' +
            '                                            ' + categories + '\n' +
            '                                        </h3>\n' +
            '                                    </div>\n' +
            '                                    <div class="anime-list__block__section__item__detail__description">\n' +
            '                                        <h3>' + element.shortDescription + '</h3>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>'

    }
}