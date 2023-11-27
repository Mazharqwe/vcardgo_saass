@php
    $cardLogo = \App\Models\Utility::get_file('card_logo/');
@endphp
<div class="modal-body">
    <div class="row">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-xxl-12 col-md-12">

                <div class="px-0 card-body">
                    <div class="tab-content" id="pills-tabContent">
                        @foreach ($businessDetails as $key => $businessDetail)
                            <div class="tab-pane text-capitalize fade show {{ $loop->index == 0 ? 'active' : '' }}"
                                id="pills-{{ strtolower($businessDetail->id) }}" role="tabpanel"
                                aria-labelledby="pills-{{ strtolower($businessDetail->id) }}-tab">
                                <div class="row workspace" data-workspace-id={{ $businessDetail->id }}>
                                    <div class="col-4 text-center">
                                        <h5 class="text-muted">{{ __('Total Business') }}</h5>
                                        <p class="text-muted text-md mb-0" data-toggle="tooltip"
                                            data-bs-original-title="{{ __('Total Business') }}"><i
                                                class="ti ti-users text-warning card-icon-text-space  mx-1"></i><span
                                                class="total_business">{{ $totalBusiness }}</span>

                                        </p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h5 class="text-muted">{{ __('Enable Business') }}</h5>
                                        <p class="text-muted text-md mb-0" data-toggle="tooltip"
                                            data-bs-original-title="{{ __('Enable Business') }}"><i
                                                class="ti ti-users text-primary card-icon-text-space  mx-1"></i><span
                                                class="enable_business">{{ $totalBusinessEnable }}</span>
                                        </p>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h5 class="text-muted">{{ __('Disable Business') }}</h5>
                                        <p class="text-muted text-md mb-0" data-toggle="tooltip"
                                            data-bs-original-title="{{ __('Disable Business') }}"><i
                                                class="ti ti-users text-danger card-icon-text-space  mx-1"></i><span
                                                class="disable_business">{{ $totalBusinessDisable }}</span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row my-2 " id="user_section_{{ $businessDetail->id }}">
                                    @foreach ($businessDetails as $businessDetail)
                                        <div class="col-md-6 my-2 ">
                                            <div
                                                class="d-flex align-items-center justify-content-between list_colume_notifi pb-2">
                                                <div class="mb-3 mb-sm-0">
                                                    <h6>
                                                        <img style="width: 30px;height: 30px;" class="rounded-circle "
                                                            src="{{ isset($val->logo) && !empty($val->logo) ? $cardLogo . '/' . $val->logo : asset('custom/img/logo-placeholder-image-21.png') }}"
                                                            alt="">
                                                        <a href="{{ url('/' . $businessDetail->slug) }}"
                                                            target="_blank" class="{{ $businessDetail->admin_enable == 'off' ? 'row-disabled' : '' }}"
                                                            id="link_{{ $businessDetail->id }}">
                                                            <label for="user"
                                                                class="form-label">{{ $businessDetail->title }}</label>
                                                        </a>
                                                    </h6>
                                                </div>
                                                <div class="text-end ">
                                                    <div class="form-check form-switch custom-switch-v1 mb-2">
                                                        <input type="checkbox" name="user_disable"
                                                            class="form-check-input input-primary is_disable"
                                                            value="1" data-id='{{ $businessDetail->id }}'
                                                            data-name="{{ __('business') }}"
                                                            {{ $businessDetail->admin_enable == 'on' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="user_disable"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".is_disable", function() {
        var id = $(this).attr('data-id');
        var is_disable = ($(this).is(':checked')) ? $(this).val() : 0;
        

        $.ajax({
                url: '{{ route('business.unable') }}',
                type: 'POST',
                data: {
                    "is_disable": is_disable,
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('.total_business').text(data.totalBusiness);
                    $('.enable_business').text(data.totalBusinessEnable);
                    $('.disable_business').text(data.totalBusinessDisable);
                    if (is_disable==0) {
                        $('#link_'+id).addClass('row-disabled');
                    } else{
                        $('#link_'+id).removeClass('row-disabled');
                    }
            }
        });
    });
</script>
