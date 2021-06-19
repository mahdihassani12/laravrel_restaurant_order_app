@if(count($menu)>0)
    @foreach($menu as $index => $f)
        <tr>
            <td id="name" menu_id="{{ $f->menu_id }}">{{ $f-> name }}</td>
            <td id="price" style="width: 18% !important;">{{ $f-> price }}</td>
            <td id="amount" style="width: 18% !important;">
                <input type="number"
                       name="amount"
                       id="amount"
                       class="amount"
                       value="1"
                       placeholder="تعداد"
                />
            </td>
            <td style="width: 18% !important;" class="process ">
                <button class="fa fa-plus"></button>
            </td>
        </tr>
    @endforeach
@else
    <tr style="background: white; text-align: center">
        <td colspan="4">اطلاعتی یافت نشد!</td>

    </tr>
@endif