import { Notification } from 'element-ui';
export function error_warning(response) {
    if (typeof response.data == 'string') {

        Notification.error({title: "出错", message: response, type: 'error',});

    } else {
        let data = response

        Object.keys(data).map(function(key, index) {
            let value = data[key];
            setTimeout(function () {
                Notification.error({title: '出错', message: value, offset: 100});
            },200)
        });

    }
}