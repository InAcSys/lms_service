using System.Text.Json;
using LMSService.Domain.Entities.Abstracts;
using LMSService.Infrastructure.Connectors.Interfaces;

namespace LMSService.Infrastructure.Repositories.Abstracts
{
    public abstract class AbstractUserRepository(
        ILMSConnector lmsConector
    ) : IUserRepository
    {
        protected ILMSConnector _lmsConector = lmsConector;

        public Task<User?> Create(User entity)
        {
            throw new NotImplementedException();
        }

        public Task<User?> Delete(int id)
        {
            throw new NotImplementedException();
        }

        public Task<IEnumerable<User>> GetAll(int pageNumber, int pageSize)
        {
            // var response = await _lmsConector.GetAsync("/accounts");
            // if (response is null)
            // {
            //     throw new ArgumentException("Users empty");
            // }
            // var content = await response.Content.ReadAsStringAsync();
            // var users = JsonSerializer.Deserialize<IEnumerable<User>>(content);
            // if (users is null)
            // {
            //     throw new ArgumentException("Users empty");
            // }
            // return users;
            throw new NotImplementedException();
        }

        public Task<User?> GetById(int id)
        {
            throw new NotImplementedException();
        }

        public Task<User?> Update(int id, User entity)
        {
            throw new NotImplementedException();
        }
    }
}
