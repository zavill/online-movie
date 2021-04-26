window.SerialList = function () {
    this.isLoadSerials = false;
    this.emptyResponse = false;

    this.serialsContainer = $('#anime-section');
    this.serialsEmptyContainer = $('#serials-empty-container');
    this.selectSort = $('#sort');
    this.filterContainer = $('#filter-container')
    this.page = 2;

    this.filter = {};

    this.init();
}

window.SerialList.prototype = {
    init: function () {
        $(window).on('scroll', $.proxy(this.onScroll, this));
        this.selectSort.on('change', $.proxy(this.onSortChange, this));
        $(this.filterContainer).find('select').on('change', $.proxy(this.onFilterChange, this));
    },

    onScroll: function () {
        if ((window.scrollY + window.innerHeight) > this.serialsContainer[0].getBoundingClientRect().bottom && !this.isLoadSerials) {
            this.loadSerials();
        }
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
                page: this.page++,
                sortField: this.selectSort.val(),
                filter: this.filter
            },
            success: function (data) {
                if (data.data.length === 0) {
                    SerialsList.emptyResponse = true;

                    if (SerialsList.page === 2) {
                        SerialsList.serialsEmptyContainer.show();
                    }
                } else if (data.data.length > 0) {
                    SerialsList.serialsEmptyContainer.hide();
                    console.log('okay');
                    data.data.forEach(function (element) {
                        let preparedNode = SerialsList.prepareSerialNode(element);
                        SerialsList.serialsContainer.append(preparedNode);
                    });
                }
                SerialsList.isLoadSerials = false;
            },
            error: function () {
                $.toast({
                    text : "Возникла ошибка при отправке запроса. \n Попробуйте позже",
                    bgColor : '#c0392b',              // Background color for toast
                    textColor : '#bdc3c7',            // text color
                    allowToastClose : true,       // Show the close button or not
                    position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    },

    onSortChange: function () {
        this.page = 1;
        this.emptyResponse = false;
        this.serialsContainer.empty();
        this.loadSerials();
    },

    onFilterChange: function () {
        this.filter = {};
        this.page = 1;
        this.emptyResponse = false;
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
            SerialsList.filter[propName] = propValue;
        });
        this.loadSerials();
        console.log(this.filter);
    },

    prepareSerialNode: function (element) {
        let categories = element.categories.join(', ');

        return '<div class="anime-item">\n' +
            '                        <div class="anime-item__poster">\n' +
            '                            <a href="' + animePlayerUrl + element.id + '"><img src="' + element.posterURL + '"></a>\n' +
            '                            <div class="rate-flag">\n' +
            '                                <div class="rate-flag__inner">\n' +
            '                                    <div class="full-star blue-svg"></div>\n' +
            '                                    <div class="rate-flag__text">' + element.averageRating + '</div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <div class="anime-item__detail">\n' +
            '                            <h2 class="anime-item__header"><a href="' + animePlayerUrl + element.id + '">' + element.name + '</a></h2>\n' +
            '                            <p><a href="' + animePlayerUrl + element.id + '">' + element.nameOrig + '</a></p>\n' +
            '                            <div class="anime-item__info">\n' +
            '                                <h2 class="anime-item__main-info">' + element.type + ' / ' + element.year + '\n' +
            '                                    / ' + categories + '</h2>\n' +
            '                            </div>\n' +
            '                            <div class="anime-item__description">\n' +
            '                                ' + element.shortDescription + '\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>'
    }
}