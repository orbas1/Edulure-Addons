import '../models/channel_message.dart';
import '../models/dm_message.dart';

abstract class RealTimeClient {
  Stream<ChannelMessage> subscribeToChannel(int channelId);
  Stream<DMMessage> subscribeToThread(int threadId);
  void dispose();
}

/// Fallback polling-based implementation that can be replaced by host apps with
/// WebSocket/Socket.IO/Echo adapters.
class PollingRealTimeClient implements RealTimeClient {
  PollingRealTimeClient();

  @override
  Stream<ChannelMessage> subscribeToChannel(int channelId) => const Stream.empty();

  @override
  Stream<DMMessage> subscribeToThread(int threadId) => const Stream.empty();

  @override
  void dispose() {}
}
