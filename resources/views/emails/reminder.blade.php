
<h4>Hello {{ $reminder->nama_sales }},</h4>

<p>Data potensi kamu dengan detail sebagai berikut : </p>
<table border="0" width="100%" align="center" valign="center">

@if($sekarang == $reminder->target_nego)
        <tr>
            <td> Target Nego</td>
            <td>:</td>
            <td>{{ $reminder->target_nego }}</td>
        </tr>
@endif

@if($sekarang == $reminder->target_quote)
        <tr>
            <td> Target Quote</td>
            <td>:</td>
            <td>{{ $reminder->target_quote }}</td>
        </tr>
@endif

@if($sekarang == $reminder->target_po)
        <tr>
            <td> Target PO</td>
            <td>:</td>
            <td>{{ $reminder->target_po }}</td>
        </tr>
@endif

    <tr>
        <td>Terminating</td>
        <td>:</td>
        <td>{{ $reminder->terminating }} </td>
    </tr>

    <tr>
        <td>Service</td>
        <td>:</td>
        <td>{{ $reminder->segmen_service }} </td>
    </tr>

    <tr>
        <td>Expired</td>
        <td>:</td>
        <td><b>1 Day</b></td>
    </tr>

</table>

<p>Sudah mencapai masa tenggang, tolong segera update dan konfirmasi yaa.Terimakasih</p>
