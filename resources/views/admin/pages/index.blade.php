<?php
<a href="{{ route('pages.create') }}">New Page</a>
<table>
  @foreach($pages as $p)
  <tr>
    <td>{{ $p->slug }}</td>
    <td>{{ $p->title }}</td>
    <td><a href="{{ route('pages.edit',$p) }}">Edit</a></td>
  </tr>
  @endforeach
</table>
{{ $pages->links() }}
