import '../api/communities_api_client.dart';
import '../models/models.dart';

class AnalyticsRepository {
  AnalyticsRepository(this._apiClient);

  final CommunitiesApiClient _apiClient;

  Future<List<HeatmapPoint>> fetchUserHeatmap(int userId) => _apiClient.getUserHeatmap(userId);
}
