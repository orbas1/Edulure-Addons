import 'package:dio/dio.dart';

import '../config/communities_config.dart';
import '../models/models.dart';
import 'api_exceptions.dart';

class CommunitiesApiClient {
  CommunitiesApiClient({Dio? dio}) : _dio = dio ?? Dio();

  final Dio _dio;

  Future<void> _applyAuth() async {
    final token = await CommunitiesAddonConfig.instance.tokenProvider();
    _dio.options.headers['Authorization'] = token != null ? 'Bearer $token' : null;
    _dio.options.headers['Accept'] = 'application/json';
  }

  String get _baseUrl => CommunitiesAddonConfig.instance.baseUrl;

  Future<List<Community>> getCommunities({Map<String, dynamic>? filters}) async {
    final response = await _get('/api/communities', queryParameters: filters);
    return (response as List<dynamic>).map((e) => Community.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<Community> getCommunity(int id) async {
    final response = await _get('/api/communities/$id');
    return Community.fromJson(response as Map<String, dynamic>);
  }

  Future<void> joinCommunity(int id) async => _post('/api/communities/$id/join');

  Future<void> leaveCommunity(int id) async => _post('/api/communities/$id/leave');

  Future<List<Channel>> getChannels(int communityId) async {
    final response = await _get('/api/communities/$communityId/channels');
    return (response as List<dynamic>).map((e) => Channel.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<List<ChannelMessage>> getChannelMessages(int channelId, {int page = 1}) async {
    final response = await _get('/api/channels/$channelId/messages', queryParameters: {'page': page});
    return (response as List<dynamic>).map((e) => ChannelMessage.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<ChannelMessage> postChannelMessage({required int channelId, required String content, List<int>? attachmentIds}) async {
    final response = await _post('/api/channels/$channelId/messages', data: {
      'content': content,
      if (attachmentIds != null) 'attachments': attachmentIds,
    });
    return ChannelMessage.fromJson(response as Map<String, dynamic>);
  }

  Future<void> reactToMessage(int messageId, String emoji) async {
    await _post('/api/channels/messages/$messageId/react', data: {'emoji': emoji});
  }

  Future<List<DMThread>> getDMThreads() async {
    final response = await _get('/api/dm/threads');
    return (response as List<dynamic>).map((e) => DMThread.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<DMThread> createDMThread({required List<int> participantIds, String? title}) async {
    final response = await _post('/api/dm/threads', data: {
      'participant_ids': participantIds,
      if (title != null) 'title': title,
    });
    return DMThread.fromJson(response as Map<String, dynamic>);
  }

  Future<List<DMMessage>> getDMMessages(int threadId, {int page = 1}) async {
    final response = await _get('/api/dm/threads/$threadId/messages', queryParameters: {'page': page});
    return (response as List<dynamic>).map((e) => DMMessage.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<DMMessage> postDMMessage({required int threadId, required String content, List<int>? attachmentIds}) async {
    final response = await _post('/api/dm/threads/$threadId/messages', data: {
      'content': content,
      if (attachmentIds != null) 'attachments': attachmentIds,
    });
    return DMMessage.fromJson(response as Map<String, dynamic>);
  }

  Future<List<LeaderboardEntry>> getCommunityLeaderboard(int communityId, {String? period}) async {
    final response = await _get('/api/communities/$communityId/leaderboard', queryParameters: {'period': period});
    return (response as List<dynamic>).map((e) => LeaderboardEntry.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<List<HeatmapPoint>> getUserHeatmap(int userId) async {
    final response = await _get('/api/users/$userId/heatmap');
    return (response as List<dynamic>).map((e) => HeatmapPoint.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<dynamic> _get(String path, {Map<String, dynamic>? queryParameters}) async {
    await _applyAuth();
    try {
      final response = await _dio.get('$_baseUrl$path', queryParameters: queryParameters);
      return response.data;
    } on DioException catch (e) {
      throw _wrapError(e);
    }
  }

  Future<dynamic> _post(String path, {Object? data}) async {
    await _applyAuth();
    try {
      final response = await _dio.post('$_baseUrl$path', data: data);
      return response.data;
    } on DioException catch (e) {
      throw _wrapError(e);
    }
  }

  Exception _wrapError(DioException e) {
    if (e.type == DioExceptionType.connectionTimeout || e.type == DioExceptionType.receiveTimeout) {
      return NetworkException('Request timed out');
    }
    final status = e.response?.statusCode;
    if (status == 401) {
      return UnauthorizedException('Authentication required');
    }
    final message = e.response?.data is Map<String, dynamic>
        ? (e.response?.data['message'] as String? ?? 'Request failed')
        : e.message ?? 'Request failed';
    return ApiException(message ?? 'Request failed', statusCode: status);
  }
}
