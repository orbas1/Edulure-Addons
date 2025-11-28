import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/channels_repository.dart';

part 'channel_messages_state.dart';

class ChannelMessagesCubit extends Cubit<ChannelMessagesState> {
  ChannelMessagesCubit(this._repository) : super(ChannelMessagesState.initial());

  final ChannelsRepository _repository;

  Future<void> load(int channelId) async {
    emit(state.copyWith(status: ChannelMessagesStatus.loading));
    try {
      final messages = await _repository.fetchMessages(channelId);
      emit(state.copyWith(status: ChannelMessagesStatus.loaded, messages: messages));
    } catch (e) {
      emit(state.copyWith(status: ChannelMessagesStatus.error, errorMessage: e.toString()));
    }
  }

  Future<void> postMessage(int channelId, String content) async {
    try {
      final posted = await _repository.postMessage(channelId: channelId, content: content);
      emit(state.copyWith(messages: [...state.messages, posted]));
    } catch (e) {
      emit(state.copyWith(status: ChannelMessagesStatus.error, errorMessage: e.toString()));
    }
  }
}
