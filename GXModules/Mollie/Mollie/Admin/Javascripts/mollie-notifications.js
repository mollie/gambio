(function() {
    const DEFAULT_PAGE = 0;
    document.addEventListener("DOMContentLoaded", function () {
        let nextButton = document.getElementById('mollie-notification-next'),
            previousButton = document.getElementById('mollie-notification-prev'),
            totalPages = document.getElementById('mollie-notification-page-count'),
            notificationWrapper = document.getElementById('mollie-notifications'),
            notificationUrl = document.getElementById('mollie-notification-url'),
            currentPage = DEFAULT_PAGE;


        if (notificationWrapper) {
            checkPreviousButton();
            checkNextButton();
            fetchNotifications(currentPage);
        }

        if (nextButton) {
            nextButton.addEventListener('click', function () {
                currentPage = currentPage + 1;
                handleNavigationButtonEvent();
            });
        }

        if (nextButton) {
            previousButton.addEventListener('click', function () {
                currentPage = currentPage - 1;
                handleNavigationButtonEvent();
            });
        }

        function handleNavigationButtonEvent() {
            document.querySelectorAll('.mollie-dynamic').forEach(e => e.remove());
            checkNextButton();
            checkPreviousButton();

            fetchNotifications(currentPage);
        }

        function fetchNotifications(page) {
            var buttonWrapper = document.querySelector('.navigation-buttons');
            MollieHttpClient.http.get(notificationUrl.value + '&page=' + page).then(
                (notifications) => {
                    let notificationsCount = notifications.length;
                    let display = notificationsCount > 0 ? 'block' : 'none';
                    document.getElementById('mollie-notifications').style.display = display;

                    for (let i = 0; i < notifications.length; i++) {
                        let row = createNotificationRow(notifications[i]);
                        if ((i % 2) === 0) {
                            row.classList.add('mollie-notification-grid');
                        }

                        notificationWrapper.insertBefore(row, buttonWrapper);
                    }
                }
            );
        }

        function createNotificationRow(notification) {
            let row = document.createElement('div');
            row.classList.add('form-group', 'mollie-vertical-align', 'mollie-dynamic');
            let idCell = createCellField('col-sm-1', notification.id);
            let dateContent = notification.date + '<br>' + notification.time;
            let dateCell = createCellField('col-sm-2', dateContent);
            let severityElem = createSeverityElem(parseInt(notification.severity));
            let severityCell = createCellField('col-sm-2', severityElem.outerHTML);
            let orderNumberElem = createCellField('col-sm-2', notification.order_number);
            let messageElem = createCellField('col-sm-2', notification.message);
            let descElem = createCellField('col-sm-3', notification.description);

            row.append(idCell, dateCell, severityCell,orderNumberElem, messageElem, descElem);

            return row;
        }

        function createSeverityElem(severityLevel) {
            let severity = 'error';
            if (severityLevel === 0) {
                severity = 'info';
            } else if (severityLevel === 1) {
                severity = 'warning';
            }

            let elem = document.createElement('div');
            elem.classList.add('badge', 'badge-' + severity, 'mollie-' + severity);
            elem.innerText = severity;

            return elem;
        }

        function createCellField(columnClass, content) {
            let cell = document.createElement('div');
            cell.classList.add(columnClass, 'mollie-vertical-align');
            cell.innerHTML = content;

            return cell;
        }

        function checkNextButton() {

            nextButton.disabled = (currentPage + 1) === parseInt(totalPages.value);
        }

        function checkPreviousButton() {
            previousButton.disabled = currentPage === 0;
        }
    });
})();
