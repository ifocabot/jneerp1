@include('layouts.erpNavigation')

<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Karyawan</h4>
                  </div>
                  <div class="card-body">
                    {{ $user }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-truck"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Kendaraan</h4>
                  </div>
                  <div class="card-body">
                    {{ $kendaraan }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-map"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Area Coverage</h4>
                  </div>
                  <div class="card-body">
                    {{ $area }}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-tasks"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Task Incomplete</h4>
                  </div>
                  <div class="card-body">
                    3
                  </div>
                </div>
              </div>
            </div>

            <!-- Card-->
            <div class="col-md-6">
              <div class="card card-hero">
                <div class="card-header">
                  <div class="card-icon">
                    <i class="fas fa-truck"></i>
                  </div>
                  <h4>{{ $kendaraanavailable }}</h4>
                  <div class="card-description">Mobil Tersedia</div>
                </div>
                <div class="card-body p-0">
                  <div class="tickets-list">
                    @foreach ($oddohistory as $oddo)
                    <a href="#" class="ticket-item">
                        <div class="ticket-title">
                            <h4>{{ $oddo->vehicles->nomor_plat }} - {{ $oddo->oddoin_id ? 'Sudah sampai gudang' : 'Sedang dalam perjalanan' }}</h4>
                        </div>
                    <div class="ticket-info">
                        <div>{{ $oddo->users->name }}</div>
                        <div class="bullet"></div>

                        @if($oddo->oddoin)
                            @if($oddo->oddoin->areas_id == 57)
                                <div class="text-primary">SPC Kresek</div>
                            @elseif($oddo->oddoin->areas_id == 58)
                                <div class="text-primary">PCK 2</div>
                            @else
                                <div class="text-primary">Belum Sampai</div>
                            @endif
                        @else
                            <div class="text-primary">Belum Sampai</div>
                        @endif
                    </div>
                    </a>
                    @endforeach

                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card card-hero">
                <div class="card-header">
                  <div class="card-icon">
                    <i class="fas fa-tools"></i>
                  </div>
                  <h4>6</h4>
                  <div class="card-description">History Services</div>
                </div>
                <div class="card-body p-0">
                  <div class="tickets-list">
                    <a href="#" class="ticket-item">
                      <div class="ticket-title">
                        <h4>Lorem ipsum dolor, sit amet consectetur adipisicing elit. A rem totam soluta, ab neque minus deserunt nemo laboriosam dolore maxime molestias quis corrupti sint suscipit est? Hic optio ratione illo!</h4>
                      </div>
                      <div class="ticket-info">
                        <div>Ifoc</div>
                        <div class="bullet"></div>
                        <div class="text-primary">1 min ago</div>
                      </div>
                    </a>
                    <a href="#" class="ticket-item">
                      <div class="ticket-title">
                        <h4>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In ex voluptates obcaecati. Earum praesentium tenetur maxime corrupti est quos. Tempore esse nobis hic temporibus minima vel est sit laborum illo.</h4>
                      </div>
                      <div class="ticket-info">
                        <div>Iqbal</div>
                        <div class="bullet"></div>
                        <div>2 hours ago</div>
                      </div>
                    </a>
                    <a href="#" class="ticket-item">
                      <div class="ticket-title">
                        <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro aliquid animi quia, repudiandae dicta nam voluptatem error odio ratione laborum doloremque excepturi, libero perspiciatis maxime veniam nulla doloribus, omnis odit?</h4>
                      </div>
                      <div class="ticket-info">
                        <div>Ifoc</div>
                        <div class="bullet"></div>
                        <div>6 hours ago</div>
                      </div>
                    </a>
                    <a href="features-tickets.html" class="ticket-item ticket-more">
                      View All <i class="fas fa-chevron-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
        </div>

    </div>
</section>

@include('layouts.erpFooter')
