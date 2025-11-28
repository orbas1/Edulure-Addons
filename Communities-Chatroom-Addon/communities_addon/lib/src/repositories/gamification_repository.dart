import '../api/communities_api_client.dart';
import '../models/models.dart';

class GamificationRepository {
  GamificationRepository(this._apiClient);

  final CommunitiesApiClient _apiClient;

  Future<List<LeaderboardEntry>> fetchLeaderboard(int communityId, {String? period}) =>
      _apiClient.getCommunityLeaderboard(communityId, period: period);
}
