<ul>
    <li><a href="javascript://" onclick="goUrl('{{ route('client.config_notice',['user_id'=>$id])}}')">공지사항/팝업</a></li>
    <li><a href="javascript://" onclick="goUrl('{{ route('client.config_sns',['user_id'=>$id])}}')">카톡</a></li>
    <li><a href="javascript://" onclick="goUrl('{{ route('client.config_cancel',['user_id'=>$id])}}')">자동취소/예약일수</a></li>
    <li><a href="javascript://" onclick="goUrl('{{ route('client.config_refund',['user_id'=>$id])}}')">위약금/유의사항</a></li>
    <li><a href="javascript://" onclick="goUrl('{{ route('client.config_booking',['user_id'=>$id])}}')">예약창설정</a></li>
</ul>
