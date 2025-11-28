import '../api/communities_api_client.dart';
import '../config/communities_config.dart';
import '../models/models.dart';

class DMRepository {
  DMRepository(this._apiClient);

  final CommunitiesApiClient _apiClient;

  Future<List<DMThread>> fetchThreads() => _apiClient.getDMThreads();

  Future<DMThread> createThread({required List<int> participantIds, String? title}) async {
    final thread = await _apiClient.createDMThread(participantIds: participantIds, title: title);
    CommunitiesAddonConfig.instance.onEvent?.call(
      CommunitiesAddonEvent(CommunitiesAddonEventType.dmStarted, metadata: {'threadId': thread.id}),
    );
    return thread;
  }

  Future<List<DMMessage>> fetchMessages(int threadId, {int page = 1}) => _apiClient.getDMMessages(threadId, page: page);

  Future<DMMessage> postMessage({required int threadId, required String content, List<int>? attachmentIds}) async {
    final message = await _apiClient.postDMMessage(threadId: threadId, content: content, attachmentIds: attachmentIds);
    CommunitiesAddonConfig.instance.onEvent?.call(
      CommunitiesAddonEvent(CommunitiesAddonEventType.messagePosted,
          metadata: {'threadId': threadId, 'messageId': message.id}),
    );
    return message;
  }
}
