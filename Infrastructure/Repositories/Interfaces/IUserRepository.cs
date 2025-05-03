using LMSService.Domain.Entities.Abstracts;
using LMSService.Infrastructure.Repositories.Interfaces;

namespace LMSService.Infrastructure.Connectors.Interfaces
{
    public interface IUserRepository : IRepository<User, int>
    {
        
    }
}
