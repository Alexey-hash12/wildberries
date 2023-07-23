@extends('app')

@section('content')

    <div class="jumbotron" style="background-color: #e9ecef;padding: 20px;">
        <div class="container">
            <h3 style="font-size: 38px;font-weight: 400;" class="display-3">Поставка: {{$income->incomeId}}</h3>
            <p>Ваша поставка</p>
            <div class="d-flex" style="font-size: 14px; column-gap: 8px;">
                <div>
                    <a style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success btn-lg" href="#" role="button">Создать Сборочное задание »</a></p>
                </div>
                <div>
                    <a style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success btn-lg" href="#" role="button">Получить поставки qrCode »</a></p>
                </div>
            </div>
        </div>
    </div>

    @if($session)
        <div class="container_my mt-2">
            <div class="alert alert-success" role="alert">
                {{$session}}
            </div>
        </div>
    @endif

    <div class="container_my mt-5 mb-5">
        <div class="card">
            <form id="myForm" action="">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    <img src="/images/filter.svg" style="width: 30px">
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="d-flex mt-4">

                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Фильтр</button>
                                    <a href="{{route('index')}}" style="margin-left: 12px;" type="submit" class="btn btn-info ml-2 mt-4">Сбросить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" id="sort_type_input" name="sort_type">
                <input type="hidden" value="" id="sort_value_input" name="sort_value">
                <div class="card-body table-responsive">
                    <table class="table table-hover" style="font-size: 12px;">
                        <thead>
                        <tr>
                            <th scope="col">
                                Идентификатор сборочного задания
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="orderId" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'orderId' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="orderId" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'orderId' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col">
                                Идентификатор склада
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="warehouseId" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'warehouseId' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="warehouseId" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'warehouseId' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col">
                                Массив баркодов товара
                            </th>
                            <th scope="col">
                                Цена поставки
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="price" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'price' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="price" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'price' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col">
                                Код валюты
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="currencyCode" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'currencyCode' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="currencyCode" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'currencyCode' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col">
                                Артикул
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="article" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'article' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="article" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'article' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col">
                                Дата создания
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="createdAt" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'createdAt' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="createdAt" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'createdAt' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col">
                                сКГТ-признак
                                <div class="d-flex" style="height: 24px;;align-items: center;column-gap: 8px;">
                                    <!-- Стрелка вверх -->
                                    <svg data-name="isLargeCargo" data-value="desc" class="form-sort strelka-top-3 {{request()->sort_type == 'isLargeCargo' && request()->sort_value=='desc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>

                                    <!-- Стрелка вниз -->
                                    <svg data-name="isLargeCargo" data-value="asc" class="form-sort strelka-bottom-3 {{request()->sort_type == 'isLargeCargo' && request()->sort_value=='asc' ? 'strelka-hovered' : ''}}" viewBox="0 0 5 9">
                                        <path d="M0.419,9.000 L0.003,8.606 L4.164,4.500 L0.003,0.394 L0.419,0.000 L4.997,4.500 L0.419,9.000 Z" ></path>
                                    </svg>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($orders))
                        @foreach($orders as $key => $order)
                            <tr style="cursor: pointer">
                                <td>
                                    {{$order->orderId}}
                                </td>
                                <td>
                                    {{$order->warehouseId}}
                                </td>
                                <td>
                                    {{implode(',', $order->skus)}}
                                </td>
                                <td>
                                    {{round($order->price, 1)}}
                                </td>
                                <td>
                                    {{$order->currencyCode}}
                                </td>
                                <td>
                                    {{$order->article}}
                                </td>
                                <td>
                                    {{$order->createdAt}}
                                </td>
                                <td>
                                    {{$order->isLargeCargo ? 'да' : 'нет'}}
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td>
                                    Нету записей
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$orders->withQueryString()->links()}}
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('myForm');

        $('.form-sort').click(function () {
            $('#sort_type_input').val($(this).data('name'));
            $("#sort_value_input").val($(this).data('value'));
            form.submit();
        });
    </script>
@endsection
