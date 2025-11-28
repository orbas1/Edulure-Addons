import '../api/communities_api_client.dart';
import '../config/communities_config.dart';
import '../models/models.dart';

class CommunitiesRepository {
  CommunitiesRepository(this._apiClient);

  final CommunitiesApiClient _apiClient;

  Future<List<Community>> fetchCommunities({Map<String, dynamic>? filters}) =>
      _apiClient.getCommunities(filters: filters);

  Future<Community> fetchCommunity(int id) => _apiClient.getCommunity(id);

  Future<void> join(int communityId) async {
    await _apiClient.joinCommunity(communityId);
    CommunitiesAddonConfig.instance.onEvent?.call(
      CommunitiesAddonEvent(CommunitiesAddonEventType.communityJoined, metadata: {'communityId': communityId}),
    );
  }

  Future<void> leave(int communityId) async {
    await _apiClient.leaveCommunity(communityId);
    CommunitiesAddonConfig.instance.onEvent?.call(
      CommunitiesAddonEvent(CommunitiesAddonEventType.communityLeft, metadata: {'communityId': communityId}),
    );
  }
}
