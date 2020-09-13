@extends("admin.pc.layout.basic")

@section("title")예약시스템 일별 매출/정산@endsection

@section("scripts")
@endsection

@section("styles")
@endsection

@section("contents")
   <div class="table-a__head clb">
							<p class="table-a__tit fl">정산 현황</p>
						</div>
						<div class="state-cal noto">
							<div class="state-cal-head">
								<div class="state-cal-head__center">
									<p class="state-cal-head__tit">2020. 08</p>
									<p class="state-cal-head__today">TODAY : 2020. 08. 13</p>
								</div>
								<div class="state-cal-head__inbox type-left">
									<a type="button" class="state-cal-head__btn type-left">2020.07</a>
									<div class="state-cal-head__info">
										<p class="state-cal-head__txt clb">정산금액 : <span class="fr">35,299,255</span></p>
										<p class="state-cal-head__txt clb">매출금액 : <span class="fr">35,299,255</span></p>
									</div>
								</div>
								<div class="state-cal-head__inbox type-right">
									<a type="button" class="state-cal-head__btn type-right">2020.09</a>
									<div class="state-cal-head__info">
										<p class="state-cal-head__txt clb">정산금액 : <span class="fr">35,299,255</span></p>
										<p class="state-cal-head__txt clb">매출금액 : <span class="fr">35,299,255</span></p>
									</div>
								</div>
							</div>
							<div class="state-cal-body">
								<table class="state-cal-body__table">
									<tr class="state-cal-body__tr type-th">
										<th class="state-cal-body__th">일</th>
										<th class="state-cal-body__th">월</th>
										<th class="state-cal-body__th">화</th>
										<th class="state-cal-body__th">수</th>
										<th class="state-cal-body__th">목</th>
										<th class="state-cal-body__th">금</th>
										<th class="state-cal-body__th">토</th>
									</tr>
									<tr class="state-cal-body__tr">
										<td class="state-cal-body__day"></td>
										<td class="state-cal-body__day"></td>
										<td class="state-cal-body__day"></td>
										<td class="state-cal-body__day"></td>
										<td class="state-cal-body__day"></td>
										<td class="state-cal-body__day"></td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">1</p>
										</td>
									</tr>
									<tr class="state-cal-body__tr">
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">2</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">3</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">4</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">5</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">6</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">7</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">8</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr type-info">
										<td class="state-cal-body__info" colspan="7">
											<ul class="state-info__list">
												<li class="state-info__item">총 정산 : 35,299,225</li>
												<li class="state-info__item">총 수수료 : 35,299,225</li>
												<li class="state-info__item">매출금액 : 35,299,225</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr">
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">9</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">10</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">11</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">12</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">13</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">14</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">15</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr type-info">
										<td class="state-cal-body__info" colspan="7">
											<ul class="state-info__list">
												<li class="state-info__item">총 정산 : 35,299,225</li>
												<li class="state-info__item">총 수수료 : 35,299,225</li>
												<li class="state-info__item">매출금액 : 35,299,225</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr">
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">16</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">17</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">18</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">19</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">20</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">21</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">22</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr type-info">
										<td class="state-cal-body__info" colspan="7">
											<ul class="state-info__list">
												<li class="state-info__item">총 정산 : 35,299,225</li>
												<li class="state-info__item">총 수수료 : 35,299,225</li>
												<li class="state-info__item">매출금액 : 35,299,225</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr">
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">23</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">24</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">25</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">26</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">27</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">28</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">29</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr type-info">
										<td class="state-cal-body__info" colspan="7">
											<ul class="state-info__list">
												<li class="state-info__item">총 정산 : 35,299,225</li>
												<li class="state-info__item">총 수수료 : 35,299,225</li>
												<li class="state-info__item">매출금액 : 35,299,225</li>
											</ul>
										</td>
									</tr>
									<tr class="state-cal-body__tr">
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">30</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">
											<p class="state-cal-body__date">31</p>
											<ul class="state-cal-body__list">
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">매출
														<span class="state-cal-body__point  type-blue">00</span>건
													</span>
													<span class="state-cal-body__val fr type-blue">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">취소
														<span class="state-cal-body__point  type-red">0</span>건
													</span>
													<span class="state-cal-body__val fr type-red">13,300,000</span>
												</li>
												<li class="state-cal-body__item clb">
													<span class="state-cal-body__name fl">정산
														<span class="state-cal-body__point  type-green">00</span>건
													</span>
													<span class="state-cal-body__val fr type-green">13,300,000</span>
												</li>
											</ul>
										</td>
										<td class="state-cal-body__day">

										</td>
										<td class="state-cal-body__day">

										</td>
										<td class="state-cal-body__day">

										</td>
										<td class="state-cal-body__day">

										</td>
										<td class="state-cal-body__day">

										</td>
									</tr>
									<tr class="state-cal-body__tr type-info">
										<td class="state-cal-body__info" colspan="7">
											<ul class="state-info__list">
												<li class="state-info__item">총 정산 : 35,299,225</li>
												<li class="state-info__item">총 수수료 : 35,299,225</li>
												<li class="state-info__item">매출금액 : 35,299,225</li>
											</ul>
										</td>
									</tr>
								</table>
							</div>
						</div>
						
						<div class="table-a noto" style="margin-top:50px;">
						<div class="table-a__head clb">
							<p class="table-a__tit fl">일일 정산</p>
							<div class="table-a_inbox type-head fr">
                               <ul class="content-search__list clb ">
                                    <li class="content-search__item fl">
                                       <div class="select-wrap w-170">
                                            <select name="" id="" class="select-v1 noto">
                                                <option value="">펜션명</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="content-search__item fl">
                                       <div class="select-wrap w-170">
                                            <select name="" id="" class="select-v1 noto">
                                                <option value="">판매채널</option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="content-search__item fl">
                                        <div class="input-wrap type-search">
                                            <input type="text" class="input-v1 va-m w-170" name="search_order_name" id="search_order_name" placeholder="예약자를 검색하세요"/>
                                            <button type="submit" class="btn-v3 type-black type-search va-m">검색</button>
                                        </div>
                                    </li>
                                </ul>
							</div>
						</div>
						<table class="table-a__table">
							<tr class="table-a__tr type-th">
								<th class="table-a__th">예약번호</th>
								<th class="table-a__th">펜션명</th>
								<th class="table-a__th">객실</th>
								<th class="table-a__th">예약<br>신청</th>
								<th class="table-a__th">판매<br>채널</th>
								<th class="table-a__th">예약자</th>
								<th class="table-a__th">연락처</th>
								<th class="table-a__th">이용일</th>
								<th class="table-a__th">매출금액</th>
								<th class="table-a__th">결제<br>방법</th>
								<th class="table-a__th">카드<br>수수료</th>
								<th class="table-a__th">예약신청<br>(구분)</th>
								<th class="table-a__th">예약대행<br>수수료</th>
								<th class="table-a__th">쿠폰/<br>포인트</th>
								<th class="table-a__th">예약<br>상태</th>
								<th class="table-a__th">정산<br>(예정)일</th>
								<th class="table-a__th">정산(예정)<br>금액</th>
							</tr>
							<?for($i=0; $i<10; $i++){?>
							<tr class="table-a__tr">
								<td class="table-a__td">12345678</td>
								<td class="table-a__td">아이넷펜션</td>
								<td class="table-a__td">테스트_101</td>
								<td class="table-a__td">펜션</td>
								<td class="table-a__td">펜션</td>
								<td class="table-a__td">홍길동</td>
								<td class="table-a__td">010-1234-1234</td>
								<td class="table-a__td">20-08-10</td>
								<td class="table-a__td">10,130,000</td>
								<td class="table-a__td">카드</td>
								<td class="table-a__td">100,000원<br>5%</td>
								<td class="table-a__td">펜션</td>
								<td class="table-a__td">1,000,000원<br>5%</td>
								<td class="table-a__td">5,000</td>
								<td class="table-a__td">대기</td>
								<td class="table-a__td">20-08-10</td>
								<td class="table-a__td">20,000,000원</td>
							</tr>
							<?}?>
						</table>

					</div>
   
   
    @foreach($order as $o)
        <p>{{$o->order_name}}, {{$o->order_hp}}, {{$o->reserve_name}}, {{$o->reserve_hp}}, {{$o->reserve_date}}, {{$o->reserve_total}}, {{$o->charge_method}}, {{$o->state}}</p>
    @endforeach

    {{ $order->links('admin.pc.pagination.default') }}
@endsection
