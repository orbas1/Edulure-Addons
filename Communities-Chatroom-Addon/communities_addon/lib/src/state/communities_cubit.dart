import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/communities_repository.dart';

part 'communities_state.dart';

class CommunitiesCubit extends Cubit<CommunitiesState> {
  CommunitiesCubit(this._repository) : super(CommunitiesInitial());

  final CommunitiesRepository _repository;

  Future<void> loadCommunities({Map<String, dynamic>? filters}) async {
    emit(CommunitiesLoading());
    try {
      final communities = await _repository.fetchCommunities(filters: filters);
      emit(CommunitiesLoaded(communities));
    } catch (e) {
      emit(CommunitiesError(e.toString()));
    }
  }
}
