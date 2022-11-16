<div class="">
    <div class="aHl"></div>
    <div id=":162" tabindex="-1"></div>
    <div id=":15r" class="ii gt" jslog="20277; u014N:xr6bB; 4:W251bGwsbnVsbCxbXV0.">
        <div id=":15q" class="a3s aiL "><u></u>
            <div marginwidth="0" marginheight="0"
                style="margin:0;padding:15px 10px;color:#292929;font-family:Helvetica,Arial,sans-serif">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%"
                    style="border-spacing:0;border-collapse:collapse;font-size:14px">
                    <tbody>
                        <tr>
                            <td align="center" valign="top" style="border-collapse:collapse">
                                <table width="600" border="0" cellpadding="0" cellspacing="0"
                                    style="border-spacing:0;border-collapse:collapse;font-size:14px;max-width:600px">
                                    <tbody>
                                        <tr id="m_4514994301439424400main">
                                            <td style="border-collapse:collapse">
                                                <table id="m_4514994301439424400main-content" border="0"
                                                    cellpadding="0" cellspacing="0" align="left"
                                                    style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody style="color: black">
                                                        <tr>
                                                            <td valign="top" style="border-collapse:collapse">
                                                                <div style="margin-top:20px"><strong
                                                                        style="font-size:16px;color: black">Kính gửi:
                                                                        Quý khách
                                                                        {{ $fullname }},</strong></div>
                                                                <div style="margin-top:10px;margin-bottom:20px;color: black">Chúc
                                                                    mừng quý khách đã đặt hàng thành công trên hệ thống
                                                                    Unismart.<br>Quý khách đặt hàng ngày
                                                                    <strong>{{ $created_at }}</strong>
                                                                    với hình thức thanh toán là
                                                                    <strong>{{ $payment_method == "home_payment" ? "Thanh toán tại nhà" : "Thanh toán tại cửa hàng" }}</strong>.
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="center" width="100%"
                                                                style="border-collapse:collapse;background-color:#f2f4f6;border-top:2px solid #646464">
                                                                <table width="48%" border="0" cellpadding="0"
                                                                    cellspacing="0" align="left"
                                                                    style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;text-align:left">
                                                                                <div>
                                                                                    <div style="color:#646464">Thông tin
                                                                                        liên hệ:</div>
                                                                                    <div style="margin-top:5px"><strong
                                                                                            style="color:#ff422a">{{ $fullname }}</strong>
                                                                                    </div>
                                                                                    <div style="margin-top:5px">Email:
                                                                                        <a href="mailto:{{ $email }}"
                                                                                            target="_blank">{{ $email }}</a><br>SĐT:
                                                                                        {{ $phone_number }}
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left"
                                                                style="border-collapse:collapse;padding:0">
                                                                <div
                                                                    style="margin-top:20px;margin-bottom:10px;margin-right:10px">
                                                                    <strong>Thông tin chi tiết đơn hàng: </strong>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td
                                                                style="border-collapse:collapse;border:1px dashed #e7ebed;border-bottom:none">
                                                                <table width="100%" border="0" cellpadding="0"
                                                                    cellspacing="0" align="left"
                                                                    style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                                    <thead>
                                                                        <tr>
                                                                            <th valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                #</th>
                                                                            <th valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                Tên sản phẩm</th>
                                                                            <th valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                Đơn giá</th>
                                                                            <th valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                Số lượng</th>
                                                                            <th valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                Thành tiền</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php
                                                                            $temp = 0;
                                                                        @endphp
                                                                        @foreach ($order_detail as $item)
                                                                            <tr style="text-align: center;">
                                                                                <td valign="top"
                                                                                style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                <div style="margin-bottom:5px;color:#646464">{{ ++$temp }}</div>
                                                                                </td>
                                                                                <td valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                    <div style="margin-bottom:5px;color:#646464">
                                                                                        {{ $item->product->name }}</div>
                                                                                </td>
                                                                                <td valign="top"
                                                                                    style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                    <div
                                                                                        style="margin-bottom:5px;color:#646464">
                                                                                        {{ number_format($item->price,0,'','.') }}vnđ</div>
                                                                                </td>
                                                                                <td valign="top"
                                                                                    style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                    <div
                                                                                        style="margin-bottom:5px;color:#646464">
                                                                                        {{ $item->quantity }}</div>
                                                                                </td>
                                                                                <td valign="top"
                                                                                    style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                                    <div
                                                                                        style="margin-bottom:5px;color:#646464">
                                                                                        {{ number_format($item->total,0,'','.') }}vnđ</div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="border-collapse:collapse;border:1px dashed #e7ebed">
                                                                <div>
                                                                    <table border="0" width="100%" cellpadding="0"
                                                                        cellspacing="0" align="left"
                                                                        style="border-spacing:0;border-collapse:collapse;font-size:14px;width:100%!important">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td valign="top" align="right"
                                                                                    style="border-collapse:collapse;padding:10px;font-size:16px;width:80%">
                                                                                    <strong>Tổng cộng:</strong>
                                                                                </td>
                                                                                <td valign="top" align="right"
                                                                                    style="border-collapse:collapse;padding:10px;font-size:16px;color:#646464;min-width:140px">
                                                                                    <strong
                                                                                        style="color:#ff422a">{{ number_format($total) }}VNĐ</strong>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td valign="top" align="right"
                                                                                    style="border-collapse:collapse;width:80%">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td align="left"
                                                                style="border-collapse:collapse;padding:0;border-top:1px dashed #e7ebed;border-bottom:2px solid #ff422a">
                                                                <table width="100%" border="0" cellpadding="0"
                                                                    cellspacing="0" align="left"
                                                                    style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td valign="bottom"
                                                                                style="border-collapse:collapse">
                                                                                <div
                                                                                    style="margin-top:20px;margin-bottom:15px">
                                                                                    <div><strong>Quý khách cần hỗ trợ
                                                                                            thêm?</strong></div>
                                                                                    <div style="margin-top:5px">Nếu có
                                                                                        bất cứ thắc mắc nào, vui lòng
                                                                                        gọi tổng đài hỗ trợ của Unismart
                                                                                        <strong
                                                                                            style="color:#ff422a">0336293669</strong>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr id="m_4514994301439424400main">
                                            <td style="border-collapse:collapse;padding-top:13px">
                                                <table id="m_4514994301439424400main-content" border="0"
                                                    cellpadding="0" cellspacing="0" align="left"
                                                    style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="bottom" align="left"
                                                                style="border-collapse:collapse;padding-top:10px;">
                                                                <div style="font-weight: bold">Cửa hàng điện thoại di động thông minh UNISMART</div>

                                                                <div style="margin-top:10px">Địa chỉ: 106 - Trần Bình -
                                                                    Cầu Giấy - Hà Nội<br>
                                                                    Điện
                                                                    thoại:&nbsp;&nbsp;0336293669<br>Email:&nbsp;&nbsp;<a
                                                                        href="mailto:nguyenkimchi10112003@gmai.com"
                                                                        style="text-decoration:none;color:#237751"
                                                                        target="_blank">nguyenkimchi10112003@gmai.com</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="yj6qo"></div>
                <div class="adL">
                </div>
            </div>
        </div>
    </div>
    <div id=":166" class="ii gt" style="display:none">
        <div id=":167" class="a3s aiL "></div>
    </div>
    <div class="hi"></div>
</div>
