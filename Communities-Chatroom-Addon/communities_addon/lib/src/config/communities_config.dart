import 'package:flutter/widgets.dart';

/// Global configuration for the Communities addon.
class CommunitiesAddonConfig {
  CommunitiesAddonConfig({
    required this.baseUrl,
    required this.tokenProvider,
    this.onEvent,
  });

  final String baseUrl;
  final Future<String?> Function() tokenProvider;
  final void Function(CommunitiesAddonEvent event)? onEvent;

  static CommunitiesAddonConfig? _instance;

  static void init(CommunitiesAddonConfig config) {
    _instance = config;
  }

  static CommunitiesAddonConfig of(BuildContext context) {
    final config = _instance;
    if (config == null) {
      throw StateError('CommunitiesAddonConfig not initialized. Call CommunitiesAddonConfig.init at startup.');
    }
    return config;
  }

  static CommunitiesAddonConfig get instance => of(_NoopContext());
}

/// Events surfaced to the host app for analytics or logging.
enum CommunitiesAddonEventType {
  communityJoined,
  communityLeft,
  messagePosted,
  dmStarted,
}

class CommunitiesAddonEvent {
  const CommunitiesAddonEvent(this.type, {this.metadata = const {}});

  final CommunitiesAddonEventType type;
  final Map<String, Object?> metadata;
}

class _NoopContext implements BuildContext {
  const _NoopContext();

  @override
  dynamic noSuchMethod(Invocation invocation) => super.noSuchMethod(invocation);
}
