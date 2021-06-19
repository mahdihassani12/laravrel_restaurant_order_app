@if(count($menu)>0)
    @foreach($menu as $index => $f)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $f-> name }}</td>
            <td>{{ $f-> price }}</td>
            <td>
                <a href="{{ route('menus.edit',$f->menu_id) }}"><i class="fa fa-edit"></i></a>
                /
                <form method="post"
                      id="form_delete"
                      action="{{ route('menus.destroy',$f->menu_id) }}">
                    @csrf
                    @method('delete')
                    <button type="submit">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
@else
    <tr style="background: white; text-align: center">
        <td colspan="4">اطلاعتی یافت نشد!</td>

    </tr>
@endif
