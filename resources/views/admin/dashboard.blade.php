<x-app-layout>
  <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold mb-6">Tableau de bord administrateur</h1>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <!-- Cartes statistiques -->
          <div class="bg-white rounded-lg shadow overflow-hidden border-t-4 border-blue-500">
              <div class="p-4 text-center">
                  <h5 class="text-gray-700 text-lg font-medium mb-2">Salles</h5>
                  <p class="text-4xl font-bold text-gray-800">{{ $totalSalles }}</p>
              </div>
          </div>

          <div class="bg-white rounded-lg shadow overflow-hidden border-t-4 border-green-500">
              <div class="p-4 text-center">
                  <h5 class="text-gray-700 text-lg font-medium mb-2">Réservations totales</h5>
                  <p class="text-4xl font-bold text-gray-800">{{ $totalReservations }}</p>
              </div>
          </div>

          <div class="bg-white rounded-lg shadow overflow-hidden border-t-4 border-cyan-500">
              <div class="p-4 text-center">
                  <h5 class="text-gray-700 text-lg font-medium mb-2">Aujourd'hui</h5>
                  <p class="text-4xl font-bold text-gray-800">{{ $reservationsAujourdhui }}</p>
              </div>
          </div>

          <div class="bg-white rounded-lg shadow overflow-hidden border-t-4 border-yellow-500">
              <div class="p-4 text-center">
                  <h5 class="text-gray-700 text-lg font-medium mb-2">À venir</h5>
                  <p class="text-4xl font-bold text-gray-800">{{ $reservationsASuivre }}</p>
              </div>
          </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <!-- Graphique des réservations par semaine -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
              <div class="bg-gray-50 px-4 py-3 border-b">
                  <h5 class="text-gray-700 font-medium">Taux d'occupation par semaine (%)</h5>
              </div>
              <div class="p-4">
                  <canvas id="weeklyChart" width="400" height="200"></canvas>
              </div>
          </div>

          <!-- Graphique des réservations par mois -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
              <div class="bg-gray-50 px-4 py-3 border-b">
                  <h5 class="text-gray-700 font-medium">Taux d'occupation par mois (%)</h5>
              </div>
              <div class="p-4">
                  <canvas id="monthlyChart" width="400" height="200"></canvas>
              </div>
          </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Top des salles les plus réservées -->
          <div class="bg-white rounded-lg shadow overflow-hidden">
              <div class="bg-gray-50 px-4 py-3 border-b">
                  <h5 class="text-gray-700 font-medium">Top 5 des salles les plus réservées</h5>
              </div>
              <div class="p-4">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                          <tr>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salle</th>
                              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de réservations</th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($topSalles as $salle)
                          <tr class="hover:bg-gray-50">
                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $salle->name }}</td>
                              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $salle->total_reservations }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
      // Données pour les graphiques
      const weeklyData = {
          labels: @json($statsParSemaine['labels']),
          datasets: [{
              label: 'Taux d\'occupation (%)',
              data: @json($statsParSemaine['data']),
              backgroundColor: 'rgba(59, 130, 246, 0.2)',
              borderColor: 'rgba(59, 130, 246, 1)',
              borderWidth: 1
          }]
      };

      const monthlyData = {
          labels: @json($statsParMois['labels']),
          datasets: [{
              label: 'Taux d\'occupation (%)',
              data: @json($statsParMois['data']),
              backgroundColor: 'rgba(239, 68, 68, 0.2)',
              borderColor: 'rgba(239, 68, 68, 1)',
              borderWidth: 1
          }]
      };

      // Configuration des graphiques
      const config = {
          type: 'bar',
          options: {
              scales: {
                  y: {
                      beginAtZero: true,
                      max: 100
                  }
              }
          }
      };

      // Initialisation des graphiques
      document.addEventListener('DOMContentLoaded', function() {
          const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
          const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

          new Chart(weeklyCtx, {
              ...config,
              data: weeklyData
          });

          new Chart(monthlyCtx, {
              ...config,
              data: monthlyData
          });
      });
  </script>
  @endpush
</x-app-layout>
