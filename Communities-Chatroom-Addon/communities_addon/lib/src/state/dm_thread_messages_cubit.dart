import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/dm_repository.dart';

part 'dm_thread_messages_state.dart';

class DMThreadMessagesCubit extends Cubit<DMThreadMessagesState> {
  DMThreadMessagesCubit(this._repository) : super(DMThreadMessagesState.initial());

  final DMRepository _repository;

  Future<void> load(int threadId) async {
    emit(state.copyWith(status: DMThreadMessagesStatus.loading));
    try {
      final messages = await _repository.fetchMessages(threadId);
      emit(state.copyWith(status: DMThreadMessagesStatus.loaded, messages: messages));
    } catch (e) {
      emit(state.copyWith(status: DMThreadMessagesStatus.error, errorMessage: e.toString()));
    }
  }

  Future<void> postMessage(int threadId, String content) async {
    try {
      final message = await _repository.postMessage(threadId: threadId, content: content);
      emit(state.copyWith(messages: [...state.messages, message]));
    } catch (e) {
      emit(state.copyWith(status: DMThreadMessagesStatus.error, errorMessage: e.toString()));
    }
  }
}
