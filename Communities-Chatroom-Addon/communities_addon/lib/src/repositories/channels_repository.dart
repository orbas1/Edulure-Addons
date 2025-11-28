import '../api/communities_api_client.dart';
import '../config/communities_config.dart';
import '../models/models.dart';

class ChannelsRepository {
  ChannelsRepository(this._apiClient);

  final CommunitiesApiClient _apiClient;

  Future<List<Channel>> fetchChannels(int communityId) => _apiClient.getChannels(communityId);

  Future<List<ChannelMessage>> fetchMessages(int channelId, {int page = 1}) =>
      _apiClient.getChannelMessages(channelId, page: page);

  Future<ChannelMessage> postMessage({required int channelId, required String content, List<int>? attachmentIds}) async {
    final message =
        await _apiClient.postChannelMessage(channelId: channelId, content: content, attachmentIds: attachmentIds);
    CommunitiesAddonConfig.instance.onEvent?.call(
      CommunitiesAddonEvent(CommunitiesAddonEventType.messagePosted,
          metadata: {'channelId': channelId, 'messageId': message.id}),
    );
    return message;
  }

  Future<void> react({required int messageId, required String emoji}) => _apiClient.reactToMessage(messageId, emoji);
}
