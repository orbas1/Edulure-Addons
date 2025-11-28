import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/dm_repository.dart';

part 'dm_threads_state.dart';

class DMThreadsCubit extends Cubit<DMThreadsState> {
  DMThreadsCubit(this._repository) : super(DMThreadsState.initial());

  final DMRepository _repository;

  Future<void> load() async {
    emit(state.copyWith(status: DMThreadsStatus.loading));
    try {
      final threads = await _repository.fetchThreads();
      emit(state.copyWith(status: DMThreadsStatus.loaded, threads: threads));
    } catch (e) {
      emit(state.copyWith(status: DMThreadsStatus.error, errorMessage: e.toString()));
    }
  }

  Future<void> createThread(List<int> participantIds, {String? title}) async {
    try {
      final thread = await _repository.createThread(participantIds: participantIds, title: title);
      emit(state.copyWith(threads: [thread, ...state.threads]));
    } catch (e) {
      emit(state.copyWith(status: DMThreadsStatus.error, errorMessage: e.toString()));
    }
  }
}
