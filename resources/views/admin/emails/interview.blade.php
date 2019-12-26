<html>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

    <!-- start permission -->
    <tr><td>Dear {!! $name !!}</td></tr>
    <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;">
            <p style="margin: 0;">Interview Email</p>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 10px; line-height: 20px; color: #666;">
            <p style="margin: 0; font-size: 12px;">Thanks for your application to our job position {!! $position !!}. We scheduled an interview with you. Please check the schedule information carefully. If you have any questions please logon our POB pro website then send your feedback.</p>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 10px; line-height: 20px; color: #666;">
            <p style="margin: 0;">Interview Date & Time: {!! $datetime !!}</p>
            <p style="margin: 0;">Location: {!! $location !!}</p>
            <p style="margin: 0;"> For more details please logon our POB pro system.
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 10px; line-height: 20px; color: #666;">
            <p style="margin: 0;">
                <a href="{{$url_link}}">Open Event In POBPro</a>
            </p>
        </td>
    </tr>
    <!-- end permission -->

    <!-- start unsubscribe -->
    <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 20px; color: #666;">
            <p style="margin: 0;">Regards</p>
            <p style="margin: 0;">HR</p>
            <p style="margin: 0;">ITforce Technology DMCC

            </p>
        </td>
    </tr>
    <!-- end unsubscribe -->

</table>
</body>
</html>