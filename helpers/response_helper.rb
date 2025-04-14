# frozen_string_literal: true

# This module provides helper methods for rendering JSON responses in a Sinatra application.
module ResponseHelper
  def json_response(object, status = :ok)
    render json: object, status: status
  end

  def json_error_response(errors, status = :unprocessable_entity)
    render json: { errors: errors }, status: status
  end

  def not_found_response
    json_error_response({ message: 'Resource not found' }, :not_found)
  end

  def unauthorized_response
    json_error_response({ message: 'Unauthorized' }, :unauthorized)
  end

  def forbidden_response
    json_error_response({ message: 'Forbidden' }, :forbidden)
  end
end
