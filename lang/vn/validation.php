<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'active_url' => ':attribute không phải là URL hợp lệ.',
    'after' => ':attribute phải là ngày sau :date.',
    'after_or_equal' => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => ':attribute chỉ có thể chứa các chữ cái, các chữ số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => ':attribute chỉ có thể chứa các chữ cái và các chữ số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là một ngày trước :date.',
    'before_or_equal' => ':attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ':attribute phải ở giữa :min và :max.',
        'file' => ':attribute phải ở giữa :min và :max kilobytes.',
        'string' => ':attribute phải ở giữa :min và :max ký tự.',
        'array' => ':attribute phải có giữa :min và :max phần tử.',
    ],
    'boolean' => 'Thuộc tính phải đúng hoặc sai.',
    'confirmed' => 'Xác nhận thuộc tính không khớp.',
    'date' => 'Thuộc tính không phải là một ngày hợp lệ.',
    'date_equals' => 'Thuộc tính phải là một ngày bằng :date.',
    'date_format' => ':attribute không khớp với định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải là :digits chữ số.',
    'digits_between' => ':attribute phải ở giữa :min và :max chữ số.',
    'dimensions' => ':attribute có kích thước ảnh không hợp lệ.',
    'distinct' => ':attribute có giá trị trùng lặp.',
    'email' => ':attribute phải là một địa chỉ email hợp lệ.',
    'ends_with' => ':attribute phải kết thúc bằng một trong các giá trị sau: :values.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là một file.',
    'filled' => ':attribute phải là một giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value characters.',
        'array' => ':attribute phải có :value phần tử hoặc hơn.',
    ],
    'image' => ':attribute phải là một ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => ':attribute không tồn tại trong :other.',
    'integer' => ':attribute phải là một số nguyên.',
    'ip' => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là một chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'string' => ':attribute phải nhỏ hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => ':attribute chỉ được nhập tối đa :max.',
        'file' => ':attribute không được lớn hơn :max kilobytes.',
        'string' => ':attribute chỉ được nhập tối đa :max ký tự.',
        'array' => ':attribute có thẻ không có nhiều hơn :max phần tử.',
    ],
    'mimes' => ':attribute phải là một loại têp: :values.',
    'mimetypes' => ':attribute phải là một loại têp: :values.',
    'min' => [
        'numeric' => ':attribute ít nhất phải là :min.',
        'file' => ':attribute ít nhất phải là :min kilobytes.',
        'string' => ':attribute ít nhất phải là :min ký tự.',
        'array' => ':attribute phải có ít nhất :min phần tử.',
    ],
    'not_in' => ':attribute đã chọn không hợp lệ.',
    'not_regex' => ':attribute định dạng không hợp lệ.',
    'numeric' => ':attribute must be a number.',
    'password' => 'password is incorrect.',
    'present' => ':attribute field must be present.',
    'regex' => ':attribute định dạng không hợp lệ.',
    'required' => 'Vui lòng nhập :attribute.',
    'required_if' => ':attribute bắt buộc khi :other là :value.',
    'required_unless' => ':attribute bắt buộc trừ khi :other trong :values.',
    'required_with' => ':attribute bắt buộc khi :values là present.',
    'required_with_all' => ':attribute bắt buộc khi :values là đúng.',
    'required_without' => ':attribute bắt buộc khi :values là không đúng.',
    'required_without_all' => ':attribute bắt buộc khi none of :values là đúng.',
    'same' => ':attribute and :other must match.',
    'size' => [
        'numeric' => ':attribute phải là :size.',
        'file' => ':attribute phải là :size kilobytes.',
        'string' => ':attribute phải là :size ký tự.',
        'array' => ':attribute phải chứa :size phần tử.',
    ],
    'starts_with' => ':attribute phải bắt đầu bằng một trong các giá trị sau: :values.',
    'string' => ':attribute phải là một chuỗi.',
    'timezone' => ':attribute phải là một khu vực hợp lệ.',
    'unique' => ':attribute đã được đăng ký.',
    'uploaded' => ':attribute không tải lên được.',
    'url' => ':attribute định dạng không hợp lệ.',
    'uuid' => ':attribute phải là UUID hợp lệ.',
    'time' => [
        'min' => ':attribute ít nhất phải là :minh.',
        'max' => ':attribute chỉ được nhập tối đa :maxh.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        ':attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'username' => 'Tên tài khoản',
        'password' => 'Mật khẩu',
        'phone' => 'Số điện thoại',
        'birthday' => 'Ngày sinh',
        'role_id' => 'Vai trò',
        'avatar' => 'Ảnh đại diện',
        'description' => 'Thông tin chi tiết',
        'is_active' => 'Trạng thái',
        'quantity' => 'Số lượng',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'brand_id' => 'Thương hiệu',
        'category_id' => 'Danh mục',
        'image' => 'Ảnh',
        'author_name' => 'Tên tác giả',
        'price' => 'Giá bán',
        'tags' => 'Nhãn loại',
        'name' => 'Tên',
        'email' => 'Email'
    ],
];
